<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffAttendance;
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
            return redirect()->back()->with('error', 'Staff record not found for this user.');
        }

        // Get the filter date or use today
        $filterDate = $request->input('filter_date') ?
            Carbon::createFromFormat('Y-m-d', $request->input('filter_date')) :
            Carbon::today();

        // Get attendance history with pagination
        $attendanceHistory = StaffAttendance::where('staff_id', $staff->id)
            ->when($request->has('filter_date'), function($query) use ($filterDate) {
                return $query->whereDate('date', $filterDate);
            })
            ->orderBy('date', 'desc')
            ->paginate(5);

        // Get today's attendance
        $todayAttendance = StaffAttendance::where('staff_id', $staff->id)
            ->whereDate('date', Carbon::today())
            ->first();

        // Calculate attendance summary
        $lastMonthStart = Carbon::today()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::today()->subMonth()->endOfMonth();

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
            'todayAttendance' => $todayAttendance,
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
        $userId = Auth::id();
        $staff = Staff::where('user_id', $userId)->first();

        if (!$staff) {
            return redirect()->back()->with('error', 'Staff record not found for this user.');
        }

        $today = Carbon::today();
        $now = Carbon::now();

        // Check if an attendance record already exists for today
        $attendance = StaffAttendance::firstOrNew([
            'staff_id' => $staff->id,
            'date' => $today,
        ]);

        // If check-in already exists, return with error
        if ($attendance->check_in) {
            return redirect()->back()->with('error', 'You have already checked in today.');
        }

        // Determine if the check-in is late (after 9:00 AM)
        $standardCheckIn = Carbon::today()->setTime(9, 0, 0);
        $status = $now->gt($standardCheckIn) ? 'late' : 'present';

        // Record check-in
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

        $today = Carbon::today();
        $now = Carbon::now();

        // Find today's attendance record
        $attendance = StaffAttendance::where('staff_id', $staff->id)
            ->whereDate('date', $today)
            ->first();

        // If no check-in record exists, return with error
        if (!$attendance) {
            return redirect()->back()->with('error', 'You need to check in first.');
        }

        // If check-out already exists, return with error
        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'You have already checked out today.');
        }

        // Record check-out
        $attendance->check_out = $now->format('H:i:s');
        $attendance->save();

        return redirect()->back()->with('message', 'Check-out recorded successfully.');
    }

    /**
     * Admin view for all staff attendance.
     */
    public function adminIndex(Request $request)
    {
        // Get filter parameters
        $filterDate = $request->input('filter_date') ?
            Carbon::createFromFormat('Y-m-d', $request->input('filter_date')) :
            Carbon::today();

        $staffId = $request->input('staff_id');

        // Get all staff
        $allStaff = Staff::select('id', 'first_name', 'last_name')->get();

        // Get attendance records with filters
        $attendanceQuery = StaffAttendance::with('staff')
            ->when($request->has('filter_date'), function($query) use ($filterDate) {
                return $query->whereDate('date', $filterDate);
            })
            ->when($staffId, function($query) use ($staffId) {
                return $query->where('staff_id', $staffId);
            })
            ->orderBy('date', 'desc');

        $attendanceRecords = $attendanceQuery->paginate(10);

        return view('admin.attendance.admin', [
            'attendanceRecords' => $attendanceRecords,
            'allStaff' => $allStaff,
            'filterDate' => $filterDate->format('Y-m-d'),
            'selectedStaffId' => $staffId,
        ]);
    }

    /**
     * Admin function to manually add or edit attendance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late',
            'notes' => 'nullable|string',
        ]);

        // Convert time inputs to proper format
        $checkIn = $request->check_in ? $request->check_in . ':00' : null;
        $checkOut = $request->check_out ? $request->check_out . ':00' : null;

        // Create or update attendance record
        StaffAttendance::updateOrCreate(
            [
                'staff_id' => $request->staff_id,
                'date' => $request->date,
            ],
            [
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $request->status,
                'notes' => $request->notes,
            ]
        );

        return redirect()->route('attendance.admin')->with('message', 'Attendance record saved successfully.');
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
