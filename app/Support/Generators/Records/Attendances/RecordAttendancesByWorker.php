<?php

namespace App\Support\Generators\Records\Attendances;

use App\Helpers\Enums\AttendanceStatus;
use App\Models\AttendanceDayWorker;

use App\Support\Assistants\WorkersAssistant;
use Illuminate\Support\Collection;
use DateTime;
use App\Models\Attendance;

class RecordAttendancesByWorker
{

    private DateTime $startDate;
    private DateTime $endDate;
    private string|null $supervisor = null;
    private string|null $team = null;
    private string|null $function = null;
    private string|null $workerDni = null;
    
    /**
     * @param array $options
     * @param DateTime $options['startDate']
     * @param DateTime $options['endDate']
     * @param null|string $options['supervisor']
     * @param null|string $options['team']
     * @param null|string $options['function']
     * @param null|string $options['workerDni']
     */
    public function __construct(array $options){
        $this->startDate = $options['startDate'];
        $this->endDate = $options['endDate'];
        $this->supervisor = $options['supervisor'];
        $this->team = $options['team'];
        $this->function = $options['function'];
        $this->workerDni = $options['workerDni'];
    }

    private function createTable():array{
        $workers = WorkersAssistant::getListWorkers();

        $query = AttendanceDayWorker::query()
            ->where('date', '>=', $this->startDate)
            ->where('date', '<=', $this->endDate);

        
        if ($this->workerDni !== null){
            $query = $query->where('worker_dni', '=', $this->workerDni);
            $workers = collect($workers)->where('dni', '=', $this->workerDni);
        }


        foreach ($workers as &$worker){
            $attendanesQuery = clone $query;
            $absencesQuery = clone $query;
            $worker['attendances'] = $attendanesQuery->where('worker_dni', '=', $worker['dni'])->where('status', '=', AttendanceStatus::Present->value)->get()->count();
            $worker['absences'] = $absencesQuery->where('worker_dni', '=', $worker['dni'])->where('status', '=', AttendanceStatus::Absent->value)->get()->count();
        }


        if ($this->team !== null){
            $workers = collect($workers)->where('team', '=', $this->team);
        }
        if ($this->function !== null){
            $workers = collect($workers)->where('function', '=', $this->function);
        }
        if ($this->supervisor !== null){
            $workers = collect($workers)->where('supervisor', '=', $this->supervisor);
        }

        $workers = collect($workers);

        $workers = array_column($workers->toArray(), null);


        return [
            'headers' => [
                [
                    'title' => 'DNI',
                    'key' => 'dni',
                ],
                [
                    'title' => 'Nombre',
                    'key' => 'name',
                ],
                [
                    'title' => 'Equipo',
                    'key' => 'team',
                ],
                [
                    'title' => 'Supervisor',
                    'key' => 'supervisor',
                ],
                [
                    'title' => 'Función',
                    'key' => 'function',
                ],
                [
                    'title' => 'Asistencias',
                    'key' => 'attendances',
                ],
                [
                    'title' => 'Inasistencias',
                    'key' => 'absences',
                ],
            ],
            'body' => $workers,
        ];
    }


    public function generate():array{
        return [
            'query' => [
                'startDate' => $this->startDate->format('c'),
                'endDate' => $this->endDate->format('c'),
                'supervisor' => $this->supervisor,
                'team' => $this->team,
                'function' => $this->function,
                'workerDni' => $this->workerDni,
            ],
            'data' => $this->createTable(),
        ];
    }
}