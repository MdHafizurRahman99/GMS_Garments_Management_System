<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleAssigned;
use Illuminate\Support\Facades\Log;

class StaffScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the week offset from the request (0 for current week, 1 for next week, -1 for previous week)
        $weekOffset = (int)$request->input('week_offset', 0);

        // Calculate the start and end date of the week based on the offset
        $currentDate = now();
        $startDate = $currentDate->copy()->startOfWeek()->addWeeks($weekOffset);
        $endDate = $startDate->copy()->endOfWeek();

        // Create an array of dates for the week
        $datesArray = [];
        for ($i = 0; $i < 7; $i++) {
            $datesArray[] = $startDate->copy()->addDays($i);
        }

        // Get all staff
        $allStaff = Staff::select('id', 'first_name', 'last_name')->get();

        // Get all shifts
        $allShifts = Shift::all();

        // Log the week we're looking at
        Log::info('Viewing week: ' . $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d'));

        // Get all schedules
        $query = StaffSchedule::with(['staff:id,first_name,last_name', 'shift:id,shift_name,start_time,end_time']);

        if (Auth::user()->hasRole('User')) {
            $userId = Auth::id();
            $staff = Staff::where('user_id', $userId)->first();

            if ($staff) {
                $query->where('staff_id', $staff->id);
            }
        }

        $allSchedules = $query->get();

        // Debug log all schedules
        foreach ($allSchedules as $schedule) {
            Log::info('Schedule found: Staff ID=' . $schedule->staff_id .
                      ', Shift ID=' . $schedule->shift_id .
                      ', Start=' . $schedule->start_date .
                      ', End=' . $schedule->end_date .
                      ', Days=' . $schedule->days);
        }

        // Filter schedules that overlap with the selected week
        $weekSchedules = $allSchedules->filter(function($schedule) use ($startDate, $endDate) {
            try {
                // Parse the start and end dates with multiple format attempts
                $scheduleStart = $this->parseDate($schedule->start_date);
                $scheduleEnd = $schedule->end_date ? $this->parseDate($schedule->end_date) : null;

                if (!$scheduleStart) {
                    Log::error('Could not parse start date: ' . $schedule->start_date);
                    return false;
                }

                // Log the parsed dates for debugging
                Log::info('Parsed dates - Schedule Start: ' . $scheduleStart->format('Y-m-d') .
                          ', Schedule End: ' . ($scheduleEnd ? $scheduleEnd->format('Y-m-d') : 'null') .
                          ', Week Start: ' . $startDate->format('Y-m-d') .
                          ', Week End: ' . $endDate->format('Y-m-d'));

                // If schedule has no end date, check if start date is before or equal to week end
                if (!$scheduleEnd) {
                    return $scheduleStart->lte($endDate);
                }

                // Check if schedule date range overlaps with week date range
                // (scheduleStart <= weekEnd) && (scheduleEnd >= weekStart)
                return $scheduleStart->lte($endDate) && $scheduleEnd->gte($startDate);
            } catch (\Exception $e) {
                Log::error('Error in date comparison: ' . $e->getMessage());
                return false;
            }
        });

        // Log how many schedules we found
        Log::info('Total schedules found: ' . $allSchedules->count());
        Log::info('Schedules for this week: ' . $weekSchedules->count());

        return view(
            'admin.staffSchedule.list',
            [
                'shifts' => $allShifts,
                'staffs' => $allStaff,
                'schedules' => $weekSchedules,
                'datesArray' => $datesArray,
                'weekOffset' => $weekOffset,
                'weekStart' => $startDate->format('Y-m-d'),
                'weekEnd' => $endDate->format('Y-m-d'),
            ]
        );
    }

    /**
     * Parse a date string with multiple format attempts
     *
     * @param string $dateString
     * @return \Carbon\Carbon|null
     */
    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        // Try different date formats - add the format from your database (d/m/Y)
        $formats = ['d/m/Y', 'Y-m-d', 'm/d/Y'];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString);
            } catch (\Exception $e) {
                continue;
            }
        }

        // If all formats fail, try to use Carbon's parse method
        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            Log::error('Failed to parse date: ' . $dateString . ' - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check for overlapping shifts
        $overlappingShifts = $this->checkForOverlappingShifts(
            $request->staff_id,
            $request->shift_id,
            $request->start_date,
            $request->end_date,
            $request->week_days
        );

        if ($overlappingShifts['hasOverlap'] && $overlappingShifts['overlapMinutes'] > 10) {
            return redirect()->back()->with('error', 'This schedule overlaps with an existing schedule by more than 10 minutes. Maximum allowed overlap is 10 minutes.');
        }

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

        // Send mail to the staff
        Mail::to($staff->email)->send(new ScheduleAssigned($request));

        return redirect()->route('staffschedule.index')->with('message', 'Schedule Added Successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffSchedule $staffSchedule)
    {
        $schedule = StaffSchedule::where('id', $request->schedule_id)->first();

        // Check for overlapping shifts (excluding the current schedule being updated)
        $overlappingShifts = $this->checkForOverlappingShifts(
            $request->staff_id,
            $request->shift_id,
            $request->start_date,
            $request->end_date,
            $request->week_days,
            $request->schedule_id
        );

        if ($overlappingShifts['hasOverlap'] && $overlappingShifts['overlapMinutes'] > 10) {
            return redirect()->back()->with('error', 'This schedule overlaps with an existing schedule by more than 10 minutes. Maximum allowed overlap is 10 minutes.');
        }

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
    }

    /**
     * Check for overlapping shifts for a staff member
     *
     * @param int $staffId
     * @param int $shiftId
     * @param string $startDate
     * @param string $endDate
     * @param array $weekDays
     * @param int|null $excludeScheduleId
     * @return array
     */
    private function checkForOverlappingShifts($staffId, $shiftId, $startDate, $endDate, $weekDays, $excludeScheduleId = null)
    {
        // Get the shift details
        $newShift = Shift::find($shiftId);
        if (!$newShift) {
            return ['hasOverlap' => false, 'overlapMinutes' => 0];
        }

        // Convert shift times to Carbon instances for comparison
        $newShiftStart = Carbon::createFromFormat('H:i', $newShift->start_time);
        $newShiftEnd = Carbon::createFromFormat('H:i', $newShift->end_time);

        // Get all existing schedules for this staff member
        $query = StaffSchedule::where('staff_id', $staffId);

        // Exclude the current schedule if we're updating
        if ($excludeScheduleId) {
            $query->where('id', '!=', $excludeScheduleId);
        }

        $existingSchedules = $query->with('shift')->get();

        $maxOverlapMinutes = 0;
        $hasOverlap = false;

        foreach ($existingSchedules as $existingSchedule) {
            // Skip if no shift associated
            if (!$existingSchedule->shift) {
                continue;
            }

            // Check if date ranges overlap
            try {
                $existingStartDate = $this->parseDate($existingSchedule->start_date);
                $existingEndDate = $existingSchedule->end_date ? $this->parseDate($existingSchedule->end_date) : null;
                $newStartDate = $this->parseDate($startDate);
                $newEndDate = $endDate ? $this->parseDate($endDate) : null;

                if (!$existingStartDate || !$newStartDate) {
                    continue;
                }
            } catch (\Exception $e) {
                // Log error and continue if date parsing fails
                Log::error('Date parsing error: ' . $e->getMessage());
                continue;
            }

            // If date ranges don't overlap, continue to next schedule
            if (($newEndDate && $newEndDate->lt($existingStartDate)) ||
                ($existingEndDate && $newStartDate->gt($existingEndDate))) {
                continue;
            }

            // Check if any weekdays overlap
            $existingDays = json_decode($existingSchedule->days);
            $daysOverlap = false;

            foreach ($weekDays as $day) {
                if (in_array($day, $existingDays)) {
                    $daysOverlap = true;
                    break;
                }
            }

            if (!$daysOverlap) {
                continue;
            }

            // Check if shift times overlap
            $existingShiftStart = Carbon::createFromFormat('H:i', $existingSchedule->shift->start_time);
            $existingShiftEnd = Carbon::createFromFormat('H:i', $existingSchedule->shift->end_time);

            // Calculate overlap
            if ($newShiftStart->lt($existingShiftEnd) && $newShiftEnd->gt($existingShiftStart)) {
                $hasOverlap = true;

                // Calculate overlap in minutes
                $overlapStart = $newShiftStart->gt($existingShiftStart) ? $newShiftStart : $existingShiftStart;
                $overlapEnd = $newShiftEnd->lt($existingShiftEnd) ? $newShiftEnd : $existingShiftEnd;
                $overlapMinutes = $overlapEnd->diffInMinutes($overlapStart);

                if ($overlapMinutes > $maxOverlapMinutes) {
                    $maxOverlapMinutes = $overlapMinutes;
                }
            }
        }

        return [
            'hasOverlap' => $hasOverlap,
            'overlapMinutes' => $maxOverlapMinutes
        ];
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
            ->where('staff_id', $staffId)
            ->where('shift_id', $shiftId)
            ->first();

        return response()->json(['data' => $schedule]);
    }

        /**
     * Get schedule data by ID.
     */
    public function getScheduleDataById(Request $request)
    {
        $scheduleId = $request->input('schedule_id');

        $schedule = StaffSchedule::with(['staff', 'shift'])
            ->where('id', $scheduleId)
            ->first();

        return response()->json(['data' => $schedule]);
    }
}
