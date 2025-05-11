<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffAttendance;
use App\Models\StaffSchedule;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffAttendanceController extends Controller
{
    /**
     * Display the attendance dashboard.
     */
    public function index(Request $request)
    {
        // Get the current user's staff record
        $userId = Auth::id();
        $staff = Staff::where('user_id', $userId)->first();

        if (!$staff) {
            return redirect('staff/create')->with('message', 'Staff record not found for this user.Please create one.');
        }

        // Get the filter date or use today
        $filterDate = $request->input('filter_date') ?
            Carbon::createFromFormat('Y-m-d', $request->input('filter_date')) :
            Carbon::today('Asia/Dhaka');

        // Get attendance history with pagination
        $attendanceHistory = StaffAttendance::with(['schedule.shift'])
            ->where('staff_id', $staff->id)
            ->when($request->has('filter_date'), function($query) use ($filterDate) {
                return $query->whereDate('date', $filterDate);
            })
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->paginate(10);

        // Get today's attendance records
        $todayAttendances = StaffAttendance::where('staff_id', $staff->id)
            ->whereDate('date', Carbon::today('Asia/Dhaka'))
            ->orderBy('check_in', 'desc')
            ->get();

        // Check if there's any incomplete attendance (checked in but not checked out)
        $incompleteAttendance = $todayAttendances->first(function($attendance) {
            return $attendance->check_in && !$attendance->check_out;
        });

        // Get available schedules for today
        $today = Carbon::now('Asia/Dhaka');
        $dayOfWeek = $today->format('D');
        $todayDate = Carbon::today('Asia/Dhaka')->toDateString(); // e.g., "2025-04-22"

        $schedules = StaffSchedule::with('shift')
            ->where('staff_id', $staff->id)
            ->get();

        // Filter schedules in PHP
        $availableSchedules = $schedules->filter(function ($schedule) use ($todayDate, $dayOfWeek) {
            try {
                // Convert start_date and end_date from DD-MM-YYYY to YYYY-MM-DD
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $schedule->start_date)->format('Y-m-d');
                $endDate = $schedule->end_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $schedule->end_date)->format('Y-m-d') : null;

                // Check date range and day of the week
                return $startDate <= $todayDate &&
                    ($endDate >= $todayDate || $endDate === null) &&
                    in_array($dayOfWeek, json_decode($schedule->days));
            } catch (\Exception $e) {
                Log::error('Error parsing schedule dates: ' . $e->getMessage());
                return false;
            }
        });

        // Calculate attendance summary
        $lastMonthStart = Carbon::today('Asia/Dhaka')->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::today('Asia/Dhaka')->subMonth()->endOfMonth();

        $onTimeCount = StaffAttendance::where('staff_id', $staff->id)
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->where('status', '!=', 'late')
            ->count();

        $lateCount = StaffAttendance::where('staff_id', $staff->id)
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->where('status', 'late')
            ->count();

        // Calculate average check-in and check-out times
        $avgCheckIn = StaffAttendance::where('staff_id', $staff->id)
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->whereNotNull('check_in')
            ->select(DB::raw('TIME_FORMAT(AVG(TIME_TO_SEC(check_in)), "%H:%i") as avg_check_in'))
            ->first();

        $avgCheckOut = StaffAttendance::where('staff_id', $staff->id)
            ->whereBetween('date', [$lastMonthStart, $lastMonthEnd])
            ->whereNotNull('check_out')
            ->select(DB::raw('TIME_FORMAT(AVG(TIME_TO_SEC(check_out)), "%H:%i") as avg_check_out'))
            ->first();

        return view('admin.attendance.index', [
            'attendanceHistory' => $attendanceHistory,
            'todayAttendances' => $todayAttendances,
            'incompleteAttendance' => $incompleteAttendance,
            'availableSchedules' => $availableSchedules,
            'onTimeCount' => $onTimeCount,
            'lateCount' => $lateCount,
            'avgCheckIn' => $avgCheckIn ? $avgCheckIn->avg_check_in : 'N/A',
            'avgCheckOut' => $avgCheckOut ? $avgCheckOut->avg_check_out : 'N/A',
            'filterDate' => $filterDate->format('Y-m-d'),
        ]);
    }

    /**
     * Record check-in time.
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:staff_schedules,id',
        ]);

        $userId = Auth::id();
        $staff = Staff::where('user_id', $userId)->first();

        if (!$staff) {
            return redirect()->back()->with('error', 'Staff record not found for this user.');
        }

        $today = Carbon::today('Asia/Dhaka');
        $now = Carbon::now('Asia/Dhaka');

        // Get the selected schedule
        $schedule = StaffSchedule::with('shift')->findOrFail($request->schedule_id);

        // Check if there's an incomplete attendance record (checked in but not checked out)
        $incompleteAttendance = StaffAttendance::where('staff_id', $staff->id)
            ->whereDate('date', $today)
            ->whereNotNull('check_in')
            ->whereNull('check_out')
            ->first();

        if ($incompleteAttendance) {
            return redirect()->back()->with('error', 'You have an incomplete check-out. Please check out first.');
        }

        // Determine if the check-in is late (after shift start time)
        $shiftStart = Carbon::parse($schedule->shift->start_time);
        $status = $now->format('H:i:s') > $shiftStart->format('H:i:s') ? 'late' : 'present';

        // Create a new attendance record
        $attendance = new StaffAttendance();
        $attendance->staff_id = $staff->id;
        $attendance->schedule_id = $schedule->id;
        $attendance->date = $today;
        $attendance->check_in = $now->format('H:i:s');
        $attendance->status = $status;
        $attendance->save();

        return redirect()->back()->with('message', 'Check-in recorded successfully.');
    }

    /**
     * Record check-out time.
     */
    public function checkOut(Request $request)
    {
        $userId = Auth::id();
        $staff = Staff::where('user_id', $userId)->first();

        if (!$staff) {
            return redirect()->back()->with('error', 'Staff record not found for this user.');
        }

        $today = Carbon::today('Asia/Dhaka');
        $now = Carbon::now('Asia/Dhaka');

        // Find the most recent incomplete attendance record
        $attendance = StaffAttendance::with('schedule.shift')
            ->where('staff_id', $staff->id)
            ->whereDate('date', $today)
            ->whereNotNull('check_in')
            ->whereNull('check_out')
            ->orderBy('check_in', 'desc')
            ->first();

        // If no incomplete check-in record exists, return with error
        if (!$attendance) {
            return redirect()->back()->with('error', 'You need to check in first.');
        }

        // Check if checkout time is after shift end time
        $shiftEnd = Carbon::parse($attendance->schedule->shift->end_time);
        $isOvertime = $now->format('H:i:s') > $shiftEnd->format('H:i:s');

        // If it's overtime and user hasn't confirmed yet, return the confirmation view
        if ($isOvertime && !$request->has('overtime_confirmed')) {
            return view('admin.attendance.overtime-confirm', [
                'attendance' => $attendance,
                'currentTime' => $now->format('H:i:s'),
                'shiftEndTime' => $shiftEnd->format('H:i:s'),
            ]);
        }

        // Process checkout based on user's overtime choice
        if ($request->has('overtime_choice')) {
            if ($request->overtime_choice === 'overtime') {
                // Record actual checkout time with overtime
                $attendance->check_out = $now->format('H:i:s');
                $attendance->is_overtime = true;
                $attendance->overtime_status = 'pending';
                $attendance->notes = $request->notes ?? $attendance->notes;
            } else {
                // Record checkout at shift end time
                $attendance->check_out = $shiftEnd->format('H:i:s');
                $attendance->is_overtime = false;
            }
        } else {
            // Normal checkout (not overtime)
            $attendance->check_out = $now->format('H:i:s');
            $attendance->is_overtime = $isOvertime;
            if ($isOvertime) {
                $attendance->overtime_status = 'pending';
            }
        }

        $attendance->save();

        return redirect()->route('attendance.index')->with('message', 'Check-out recorded successfully.');
    }

    /**
     * Admin view for all staff attendance.
     */
    public function adminIndex(Request $request)
    {
        // Get filter parameters
        $filterDate = $request->input('filter_date') ?
            Carbon::createFromFormat('Y-m-d', $request->input('filter_date')) :
            Carbon::today('Asia/Dhaka');

        $staffId = $request->input('staff_id');
        $overtimeFilter = $request->input('overtime_filter');

        // Get all staff
        $allStaff = Staff::select('id', 'first_name', 'last_name')->get();

        // Get attendance records with filters
        $attendanceQuery = StaffAttendance::with(['staff', 'schedule.shift'])
            ->when($request->has('filter_date'), function($query) use ($filterDate) {
                return $query->whereDate('date', $filterDate);
            })
            ->when($staffId, function($query) use ($staffId) {
                return $query->where('staff_id', $staffId);
            })
            ->when($overtimeFilter, function($query) use ($overtimeFilter) {
                if ($overtimeFilter === 'pending') {
                    return $query->where('is_overtime', true)
                                ->where('overtime_status', 'pending');
                } elseif ($overtimeFilter === 'approved') {
                    return $query->where('is_overtime', true)
                                ->where('overtime_status', 'approved');
                } elseif ($overtimeFilter === 'rejected') {
                    return $query->where('is_overtime', true)
                                ->where('overtime_status', 'rejected');
                } elseif ($overtimeFilter === 'all_overtime') {
                    return $query->where('is_overtime', true);
                }
            })
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc');

        $attendanceRecords = $attendanceQuery->paginate(10);

        return view('admin.attendance.admin', [
            'attendanceRecords' => $attendanceRecords,
            'allStaff' => $allStaff,
            'filterDate' => $filterDate->format('Y-m-d'),
            'selectedStaffId' => $staffId,
            'overtimeFilter' => $overtimeFilter,
        ]);
    }

    /**
     * Admin function to manually add or edit attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'schedule_id' => 'required|exists:staff_schedules,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late',
            'is_overtime' => 'nullable|boolean',
            'overtime_status' => 'nullable|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        // Convert time inputs to proper format
        $checkIn = $request->check_in ? $request->check_in . ':00' : null;
        $checkOut = $request->check_out ? $request->check_out . ':00' : null;

        // If we have an ID, update the existing record
        if ($request->has('id') && $request->id) {
            $attendance = StaffAttendance::findOrFail($request->id);
            $attendance->update([
                'staff_id' => $request->staff_id,
                'schedule_id' => $request->schedule_id,
                'date' => $request->date,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $request->status,
                'is_overtime' => $request->is_overtime ?? false,
                'overtime_status' => $request->overtime_status,
                'notes' => $request->notes,
            ]);
        } else {
            // Create a new attendance record
            StaffAttendance::create([
                'staff_id' => $request->staff_id,
                'schedule_id' => $request->schedule_id,
                'date' => $request->date,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $request->status,
                'is_overtime' => $request->is_overtime ?? false,
                'overtime_status' => $request->overtime_status,
                'notes' => $request->notes,
            ]);
        }

        return redirect()->route('attendance.admin')->with('message', 'Attendance record saved successfully.');
    }

    /**
     * Admin function to approve or reject overtime.
     */
    public function updateOvertimeStatus(Request $request, $id)
    {
        $request->validate([
            'overtime_status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $attendance = StaffAttendance::findOrFail($request->id);

        // return $attendance;
        // return $request->id;
        if (!$attendance->is_overtime) {
            return redirect()->back()->with('error', 'This attendance record does not have overtime.');
        }

        $attendance->overtime_status = $request->overtime_status;

        if ($request->notes) {
            $attendance->notes = $request->notes;
        }

        $attendance->save();

        return redirect()->back()->with('message', 'Overtime status updated successfully.');
    }

    /**
     * Admin function to delete an attendance record.
     */
    public function destroy($id)
    {
        $attendance = StaffAttendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendance.admin')->with('message', 'Attendance record deleted successfully.');
    }
}
