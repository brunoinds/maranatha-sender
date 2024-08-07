<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceDayWorkerRequest;
use App\Http\Requests\UpdateAttendanceDayWorkerRequest;
use App\Models\Attendance;
use App\Models\AttendanceDayWorker;
use App\Support\Cache\RecordsCache;

class AttendanceDayWorkerController extends Controller
{
    public function index()
    {
        $allAttendancesDayWorker = AttendanceDayWorker::all();
        return response()->json($allAttendancesDayWorker->toArray());
    }

    public function listByAttendance(Attendance $attendance)
    {
        $allAttendancesDayWorker = AttendanceDayWorker::all()->where('attendance_id', $attendance->id);
        return response()->json($allAttendancesDayWorker->toArray());
    }

    public function store(StoreAttendanceDayWorkerRequest $request)
    {
        $attendance = AttendanceDayWorker::create($request->validated());
        RecordsCache::clearAll();
        return response()->json(['message' => 'Attendance Day-Worker created', 'attendance' => $attendance->toArray()]);
    }

    public function update(UpdateAttendanceDayWorkerRequest $request, AttendanceDayWorker $attendanceDayWorker)
    {
        $attendanceDayWorker->update($request->validated());
        RecordsCache::clearAll();
        return response()->json(['message' => 'Attendance Day-Worker updated', 'attendance' => $attendanceDayWorker->toArray()]);
    }

    public function destroy(AttendanceDayWorker $attendanceDayWorker)
    {
        //
    }
}
