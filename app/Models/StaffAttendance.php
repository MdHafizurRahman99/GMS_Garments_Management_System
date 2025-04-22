<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StaffAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'schedule_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'is_overtime',
        'overtime_status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'is_overtime' => 'boolean',
    ];

    /**
     * Get the staff that owns the attendance record.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Get the schedule associated with this attendance.
     */
    public function schedule()
    {
        return $this->belongsTo(StaffSchedule::class, 'schedule_id');
    }

    /**
     * Calculate the duration between check-in and check-out.
     */
    public function getDurationAttribute()
    {
        if (!$this->check_in || !$this->check_out) {
            return null;
        }

        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);

        return $checkOut->diffInMinutes($checkIn);
    }

    /**
     * Format duration as hours and minutes.
     */
    public function getFormattedDurationAttribute()
    {
        $duration = $this->getDurationAttribute();

        if ($duration === null) {
            return 'N/A';
        }

        $hours = floor($duration / 60);
        $minutes = $duration % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    /**
     * Check if the attendance is late.
     */
    public function getIsLateAttribute()
    {
        if (!$this->check_in || !$this->schedule) {
            return false;
        }

        $scheduleStart = Carbon::parse($this->schedule->shift->start_time);
        $actualCheckIn = Carbon::parse($this->check_in);

        return $actualCheckIn->gt($scheduleStart);
    }

    /**
     * Get the overtime duration in minutes.
     */
    public function getOvertimeDurationAttribute()
    {
        if (!$this->is_overtime || !$this->check_out || !$this->schedule) {
            return 0;
        }

        $scheduleEnd = Carbon::parse($this->schedule->shift->end_time);
        $actualCheckOut = Carbon::parse($this->check_out);

        if ($actualCheckOut->gt($scheduleEnd)) {
            return $actualCheckOut->diffInMinutes($scheduleEnd);
        }

        return 0;
    }

    /**
     * Format overtime duration as hours and minutes.
     */
    public function getFormattedOvertimeDurationAttribute()
    {
        $duration = $this->getOvertimeDurationAttribute();

        if ($duration === 0) {
            return '00:00';
        }

        $hours = floor($duration / 60);
        $minutes = $duration % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
