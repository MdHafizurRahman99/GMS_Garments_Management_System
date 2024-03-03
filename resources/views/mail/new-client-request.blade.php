<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Company!</title>
    <style>
        /* Style your email content here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4285f4;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to EMS</h1>
        <p>Dear {{ $userinfo->first_name . ' ' . $userinfo->last_name }},</p>
        {{-- <p>Congratulations on joining our team! We are thrilled to have you on board.</p> --}}
        <p>To facilitate a smooth onboarding process, please click on the link:</p>
        {{-- <ol>
            <li>Review the attached employee handbook for important company policies and guidelines.</li>
            <li>Complete the necessary paperwork and provide the requested documentation.</li>
            <li>Schedule an introductory meeting with your manager to discuss your role and responsibilities.</li>
        </ol>
        <p>If you have any questions or need assistance, feel free to contact our HR department at [HR Email/Phone].</p>
        <p>We're excited to see you grow and succeed with us!</p>
        <p>Best regards,<br> [Your Company Name] Team</p> --}}
        <p><a href="{{ route('client.create') }}" class="cta-button">Click Here</a></p>
    </div>
</body>

</html>
