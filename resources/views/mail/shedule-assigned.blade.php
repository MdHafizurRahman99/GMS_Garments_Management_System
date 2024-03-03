<!DOCTYPE html>
<html>

<head>
    <title>Schedule Assigned</title>
</head>

<body>
    <h1>Schedule Assigned</h1>

    <p>Hello,</p>

    <p>We're reaching out to inform you that a new schedule has been assigned.</p>
    <p>Please check your profile.</p>
    <p><a href="{{ route('staffschedule.index') }}" class="cta-button">Click Here</a></p>
    {{-- <p>Details:</p>
    <ul>
        <li><strong>Date:</strong> {{ $schedule->date }}</li>
        <li><strong>Time:</strong> {{ $schedule->time }}</li>
        <!-- Add more details as needed -->
    </ul> --}}

    <p>Thank you.</p>
</body>

</html>
