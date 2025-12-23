<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatLog;
use App\Models\Doctor;
use App\Models\Appointment;
use OpenAI;

class AIController extends Controller
{
    public function index()
    {
        return view('backend.chat.index');
    }

    public function history()
    {
        $logs = ChatLog::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($logs);
    }

    // MAIN CHAT MESSAGE HANDLER
    public function sendMessage(Request $request)
    {
        $message = strtolower($request->message);
        $user = Auth::user();

        $intent = $this->detectIntent($message);

        switch ($intent) {
            case 'symptom_check':
                $reply = $this->processSymptomCheck($message);
                break;

            case 'doctor_referral':
                $reply = $this->referDoctorAndShowTimes($message); // improved
                break;

            case 'appointment_check':
                $reply = $this->checkDoctorAvailability($message);
                break;

            default:
                $reply = $this->askOpenAI($message);
        }

        ChatLog::create([
            "user_id"      => $user->id,
            "query_text"   => $message,
            "response_text" => $reply
        ]);

        return response()->json(["reply" => $reply]);
    }


    // INTENT DETECTOR
    private function detectIntent($text)
    {
        if (str_contains($text, 'pain') || str_contains($text, 'hurt') || str_contains($text, 'fever') || str_contains($text, 'cough'))
            return 'symptom_check';

        if (str_contains($text, 'refer') || str_contains($text, 'doctor') || str_contains($text, 'specialist') || str_contains($text, 'yes'))
            return 'doctor_referral';

        if (str_contains($text, 'book') || str_contains($text, 'available') || str_contains($text, 'appointment') || str_contains($text, 'time'))
            return 'appointment_check';

        return 'general';
    }

    // AI SYMPTOM CHECKING
    private function processSymptomCheck($symptoms)
    {
        $prompt = "
        You are a medical assistant.
        User symptoms: $symptoms
        1. Give possible causes in bullet points. 
        2. Give simple advice.
        3. Ask: “Do you want a doctor referral?”
        ";

        return $this->askOpenAI($prompt);
    }

    //AI DOCTOR REFERRAL + SHOW AVAILABLE TIMES
    private function referDoctorAndShowTimes($message)
    {
        // AI picks correct field
        $prompt = "
        Message: '$message'
        Pick the most suitable specialization from this list:
        Cardiology, Pediatrics, Neurology, Dermatology, General Medicine, General Dentistry
        Return ONLY one word.
        ";

        $specialization = trim($this->askOpenAI($prompt));

        // Find doctor
        $doctor = Doctor::where('specialization', 'LIKE', "%$specialization%")->first();

        if (!$doctor)
            return " No doctor available for $specialization.";

        $name = $doctor->user->name;

        // Fetch next available times
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>=', today()->format('Y-m-d'))
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->take(5)
            ->get();

        $slots = "No times available.";

        if ($appointments->count() > 0) {
            $slots = "";
            foreach ($appointments as $appt) {
                $slots .= "- {$appt->appointment_date} at {$appt->appointment_time}\n";
            }
        }

        return "
            Based on your symptoms, I recommend a $specialization doctor.

            Dr. $name 
            Specialization: $specialization

            Available Times: 
            $slots

            To book an appointment, type:  
            book Dr. $name
            ";
    }

    // 3. CHECK AVAILABILITY (USER ASKS)
    private function checkDoctorAvailability($message)
    {
        // Extract doctor name
        preg_match('/dr\\.\\s*([a-zA-Z ]+)/i', $message, $match);

        if (!isset($match[1])) {
            return "Please specify doctor name, e.g. *Check availability for Dr. John*";
        }

        $name = trim($match[1]);

        // Find doctor
        $doctor = Doctor::whereHas('user', function ($q) use ($name) {
            $q->where('name', 'LIKE', "%$name%");
        })->first();

        if (!$doctor) {
            return "I couldn’t find a doctor named Dr. $name.";
        }

        // Fetch all upcoming appointments
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>=', now()->format('Y-m-d'))
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        $count = $appointments->count();

        // CASE 1: Slots full
        if ($count >= 10) {
            return "
            **Dr. {$doctor->user->name}'s schedule is full.**
            He already has **$count appointments**, so no time slots left.
            ";
        }

        // CASE 2: Show available slots (less than 10)
        if ($count == 0) {
            return "
        Dr. {$doctor->user->name} has no appointments yet.
        All dates are open.
        ";
        }

        // Build list of available times
        $slots = "";
        foreach ($appointments as $appt) {
            $slots .= "- {$appt->appointment_date} at {$appt->appointment_time}\n";
        }

        return "
        Dr. {$doctor->user->name} Availability

        He currently has $count / 10 appointments.

        Here are his upcoming scheduled days (less than 10):

        $slots

        You may ask:  
        “What date can I meet him?”* (to show free dates)
        ";
    }


    // OPENAI WRAPPER
    private function askOpenAI($prompt)
    {
        try {
            $client = \OpenAI::client(env('OPENAI_API_KEY'));

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are MediSync AI. Provide short, clear answers.'],
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

            return trim($response->choices[0]->message->content);
        } catch (\Exception $e) {
            return "AI Error: " . $e->getMessage();
        }
    }
}
