<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        h2 {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        h3 {
            color: #0d6efd;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 5px solid #0d6efd;
        }

        .section p {
            margin: 8px 0;
            font-size: 15px;
        }

        strong {
            color: #555;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .status.Pending { background-color: #ffbf00; }
        .status.Confirmed { background-color: #0d55f0; }
        .status.Completed { background-color: #198754; }
        .status.Cancelled { background-color: #dc3545; }
        .status.Default { background-color: #6c757d; }

    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment Information</h2>

        <div class="section">
            <p><strong>Appointment Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</p>
            <p><strong>Appointment Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
            <p><strong>Status:</strong> 
                <span class="status 
                @if($appointment->status == 'Pending') Pending 
                @elseif($appointment->status == 'Confirmed') Confirmed 
                @elseif($appointment->status == 'Completed') Completed 
                @elseif($appointment->status == 'Cancelled') Cancelled 
                @else Default @endif">
                {{ $appointment->status ?? 'N/A' }}
                </span>
            </p>
            @if ($appointment->next_appointment_date)
            <p><strong>Next Appointment Date:</strong> {{ \Carbon\Carbon::parse($appointment->next_appointment_date)->format('F d, Y') }}</p>
            @endif
        </div>

        <h3>Doctor Details</h3>
        <div class="section">
            <p><strong>Name:</strong> {{ $appointment->doctor->user->name }}</p>
            <p><strong>Department:</strong> {{ $appointment->doctor->department }}</p>
            <p><strong>Specialization:</strong> {{ $appointment->doctor->specialization }}</p>
        </div>

        <h3>Patient Details</h3>
        <div class="section">
            <p><strong>Name:</strong> {{ $appointment->patient->user->name }}</p>
            @if (!empty($appointment->patient->user->email))
            <p><strong>Email:</strong> {{ $appointment->patient->user->email }}</p>
            @endif
            @if (!empty($appointment->patient->user->phone))
            <p><strong>Phone:</strong> {{ $appointment->patient->user->phone }}</p>
            @endif
        </div>

        @if (!empty($appointment->notes))
        <h3>Notes</h3>
        <div class="section">
            <p>{{ $appointment->notes }}</p>
        </div>
        @endif
    </div>
</body>
</html>
