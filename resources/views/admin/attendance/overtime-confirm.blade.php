@extends('layouts.admin.master')

@section('title')
    Overtime Confirmation
@endsection

@section('css')
    <style>
        .overtime-card {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .time-display {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .time-value {
            font-weight: bold;
        }

        .choice-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .notes-section {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <div id="content">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Overtime Confirmation</h1>

            <div class="overtime-card">
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i>
                    You are checking out after your scheduled shift end time.
                </div>

                <div class="time-display">
                    <div>Current Time: <span class="time-value">{{ \Carbon\Carbon::parse($currentTime)->format('h:i A') }}</span></div>
                    <div>Shift End Time: <span class="time-value">{{ \Carbon\Carbon::parse($shiftEndTime)->format('h:i A') }}</span></div>
                    <div>Overtime: <span class="time-value">
                        {{ \Carbon\Carbon::parse($currentTime)->diffForHumans(\Carbon\Carbon::parse($shiftEndTime), ['parts' => 2]) }}
                    </span></div>
                </div>

                <p>Please select one of the following options:</p>

                <form action="{{ route('attendance.check-out') }}" method="POST">
                    @csrf
                    <input type="hidden" name="overtime_confirmed" value="1">

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="overtime_choice" id="overtime_yes" value="overtime" checked>
                        <label class="form-check-label" for="overtime_yes">
                            Yes, I am working overtime (requires admin approval)
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="overtime_choice" id="overtime_no" value="regular">
                        <label class="form-check-label" for="overtime_no">
                            No, check me out at my scheduled end time
                        </label>
                    </div>

                    <div class="notes-section" id="notes_section">
                        <label for="notes">Reason for overtime:</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Please provide a reason for working overtime"></textarea>
                    </div>

                    <div class="choice-buttons">
                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Confirm Check Out</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Show/hide notes section based on overtime choice
        document.addEventListener('DOMContentLoaded', function() {
            const overtimeYes = document.getElementById('overtime_yes');
            const overtimeNo = document.getElementById('overtime_no');
            const notesSection = document.getElementById('notes_section');

            function toggleNotesSection() {
                if (overtimeYes.checked) {
                    notesSection.style.display = 'block';
                } else {
                    notesSection.style.display = 'none';
                }
            }

            overtimeYes.addEventListener('change', toggleNotesSection);
            overtimeNo.addEventListener('change', toggleNotesSection);

            // Initial state
            toggleNotesSection();
        });
    </script>
@endsection
