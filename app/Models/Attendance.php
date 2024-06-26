<?php

namespace App\Models;

use App\Helpers\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Job;
use App\Models\Expense;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_date',
        'to_date',
        'job_code',
        'expense_code',
        'description',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function job(){
        return $this->belongsTo(Job::class, 'job_code', 'code');
    }
    public function expense(){
        return $this->belongsTo(Expense::class, 'expense_code', 'code');
    }
    public function dates(): array
    {
        $startDate = Carbon::parse($this->from_date)->startOfDay();
        $endDate = Carbon::parse($this->to_date)->endOfDay();

        $period = CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $dates[] = $date->toDateTime();
        }
        return $dates;
    }
    public function datesWorkers():array
    {
        $dayWorkers = $this->dayWorkers();
        $dates = $this->dates();

        $datesWorkers = [];
        foreach($dates as $date){
            $dateWorkers = [];
            foreach($dayWorkers as $dayWorker){
                if ((new \DateTime($dayWorker->date))->format('c') === $date->format('c')){
                    $dateWorkers[] = $dayWorker;
                }
            }
            $datesWorkers[] = [
                'date' => $date->format('c'),
                'workers' => $dateWorkers,
            ];
        }

    }

    public function dayWorkers()
    {
        return AttendanceDayWorker::where('attendance_id', $this->id)->get();
    }

    public function attachWorkerDni(string $workerDni)
    {
        $records = collect($this->dates())->map(function(\DateTime $date) use ($workerDni){
            return [
                'worker_dni' => $workerDni,
                'attendance_id' => $this->id,
                'date' => $date->format('c'),
                'status' => AttendanceStatus::Present,
            ];
        })->toArray();

        AttendanceDayWorker::insert($records);
    }


    public function removeWorkerDni(string $workerDni)
    {
        foreach ($this->dayWorkers()->filter(function ($dayWorker) use ($workerDni) {
            return $dayWorker->worker_dni === $workerDni;
        }) as $dayWorker) {
            $dayWorker->delete();
        }
    }

    public function updateFromToDatesInAttendanceDayWorker()
    {
        $instance = $this;
        $dates = $this->dates();
        $dayWorkers = $this->dayWorkers();

        $dayWorkersDNIs = $dayWorkers->map(function(AttendanceDayWorker $dayWorker){
            return $dayWorker->worker_dni;
        })->unique();

        $dayWorkerIdsToDelete = $dayWorkers->filter(function(AttendanceDayWorker $dayWorker) use ($dates){
            $date = new \DateTime($dayWorker->date);
            return !in_array($date, $dates);
        })->pluck('id');

        AttendanceDayWorker::whereIn('id', $dayWorkerIdsToDelete)->delete();

        $dayWorkers = $this->dayWorkers();

        collect($dates)->each(function(\DateTime $date) use ($dayWorkers, $instance, $dayWorkersDNIs){
            $dateString = $date->format('c');
            $dayWorker = $dayWorkers->first(function(AttendanceDayWorker $dayWorker) use ($dateString){
                return $dayWorker->date === $dateString;
            });
            if ($dayWorker === null){
                $records = $dayWorkersDNIs->map(function(string $workerDni) use ($date, $instance){
                    return [
                        'worker_dni' => $workerDni,
                        'attendance_id' => $instance->id,
                        'date' => $date->format('c'),
                        'status' => AttendanceStatus::Present,
                    ];
                })->toArray();

                AttendanceDayWorker::insert($records);
            }
        });
    }

    public function updateWorkersDnis(array $workersDnis)
    {
        $dayWorkers = $this->dayWorkers();
        $dayWorkersDNIs = $dayWorkers->map(function(AttendanceDayWorker $dayWorker){
            return $dayWorker->worker_dni;
        })->unique();

        $workersDnisToDelete = $dayWorkersDNIs->diff($workersDnis);
        $workersDnisToAdd = collect($workersDnis)->diff($dayWorkersDNIs);

        $workersDnisToDelete->each(function(string $workerDni){
            $this->removeWorkerDni($workerDni);
        });

        $workersDnisToAdd->each(function(string $workerDni){
            $this->attachWorkerDni($workerDni);
        });
    }

    public function delete(){
        $this->dayWorkers()->each(function(AttendanceDayWorker $dayWorker){
            $dayWorker->delete();
        });
        parent::delete();
    }
}
