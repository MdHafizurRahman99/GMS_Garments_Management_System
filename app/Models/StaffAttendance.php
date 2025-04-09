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
        'date',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    /**
     * Get the staff that owns the attendance record.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
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
        if (!$this->check_in) {
            return false;
        }

        // Assuming 9:00 AM is the standard check-in time
        $standardCheckIn = Carbon::parse($this->date)->setTime(9, 0, 0);
        $actualCheckIn = Carbon::parse($this->check_in);

        return $actualCheckIn->gt($standardCheckIn);
    }
}
