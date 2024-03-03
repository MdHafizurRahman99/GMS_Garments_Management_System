<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleAssigned;

class StaffScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('User')) {
            $userId = Auth::id();
            $staff = Staff::where('user_id', $userId)->first();
            // return $staff;
            if ($staff) {
                $staffSchedules = StaffSchedule::with(['staff:id,first_name,last_name', 'shift:id,shift_name'])
                    ->where('staff_id', $staff->id)
                    // ->where('publish', 'Published')
                    ->get();
            } else {
                $staffSchedules = [];
            }

            // return $staffSchedules;
            return view(
                'admin.staffSchedule.list',
                [
                    'shifts' => Shift::all(),
                    'staffs' => Staff::select('id', 'first_name', 'last_name')->get(),
                    'schedules' => $staffSchedules,
                ]
            );
        } else {
            $staffSchedules = StaffSchedule::with(['staff:id,first_name,last_name', 'shift:id,shift_name'])
                // ->where('publish', 'Published')
                ->get();
            // return $staffSchedules;
            return view(
                'admin.staffSchedule.list',
                [
                    'shifts' => Shift::all(),
                    'staffs' => Staff::select('id', 'first_name', 'last_name')->get(),
                    'schedules' => $staffSchedules,
                ]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $schedule = StaffSchedule::create([
            'staff_id' => $request->staff_id,
            'shift_id' => $request->shift_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => json_encode($request->week_days),
            'note' => $request->note,
            'publish' => $request->publish,
        ]);
        $staff = Staff::where('id', $request->staff_id)->first();

        //send mail to the staff 
        Mail::to($staff->email)->send(new ScheduleAssigned($request));

        return redirect()->route('staffschedule.index')->with('message', 'Schedule Added Successfully!');
        // return $request;
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffSchedule $staffSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffSchedule $staffSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffSchedule $staffSchedule)
    {
        $schedule = StaffSchedule::where('id', $request->schedule_id)->first();
        // return $schedule;

        $schedule->update([
            'staff_id' => $request->staff_id,
            'shift_id' => $request->shift_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days' => json_encode($request->week_days),
            'note' => $request->note,
            'publish' => $request->publish,
        ]);
        return redirect()->route('staffschedule.index')->with('message', 'Schedule Updated Successfully!');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffSchedule $staffSchedule)
    {
        //
    }

    public function getSchedulData(Request $request)
    {
        $staffId = $request->input('staff_id');
        $shiftId = $request->input('shift_id');

        $schedule = StaffSchedule::with(['staff', 'shift'])
            ->where('shift_id', $shiftId)
            ->first();

        // return $schedule;
        // Retrieve schedule data based on staff ID and shift ID
        // $schedule = Schedule::where('staff_id', $staffId)
        //     ->where('shift_id', $shiftId)
        //     ->first();

        // You might want to add additional error handling here if the schedule is not found

        return response()->json(['data' => $schedule]);
    }
}
