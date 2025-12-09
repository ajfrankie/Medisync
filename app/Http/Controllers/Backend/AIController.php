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
        return response()->json(
            ChatLog::where('user_id', Auth::id())
                ->orderBy('created_at')
                ->get()
        );
    }

    // ------------------------------------------
    // MAIN CHAT HANDLER
    // ------------------------------------------
    public function sendMessage(Request $request)
    {
        $msg = trim($request->message);
        $user = Auth::user();

        // Detect intent using AI classifier
        $intent = $this->detectIntentAI($msg);

        switch ($intent) {

            case "symptoms":
                $reply = $this->handleSymptoms($msg);
                break;

            case "doctor_referral":
                $reply = $this->referDoctorFromDB($msg);
                break;

            case "appointment_query":
                $reply = $this->doctorAvailability($msg);
                break;

            case "appointment_booking":
                $reply = $this->bookDoctor($msg);
                break;

            default:
                $reply = $this->askOpenAI($msg);
        }

        ChatLog::create([
            "user_id" => $user->id,
            "query_text" => $msg,
            "response_text" => $reply
        ]);

        return response()->json(["reply" => $reply]);
    }

    // ------------------------------------------
    // AI POWERED INTENT DETECTOR
    // ------------------------------------------
    private function detectIntentAI($text)
    {
        $prompt = "
Classify this message into one intent ONLY:
- symptoms     (user describing symptoms)
- doctor_referral (user wants specialist / doctor)
- appointment_query (user asks doctor availability)
- appointment_booking (user wants to book)
- general

Message: \"$text\"
Return only the intent word.
";

        $intent = strtolower($this->askOpenAI($prompt));

        if (!in_array($intent, [
            'symptoms', 'doctor_referral',
            'appointment_query', 'appointment_booking',
            'general'
        ])) {
            return "general";
        }

        return $intent;
    }

    // ------------------------------------------
    // 1. SYMPTOM HANDLER (AI)
    // ------------------------------------------
    private function handleSymptoms($text)
    {
        $prompt = "
User symptoms: $text
1. Analyse symptoms.
2. Give possible causes.
3. Suggest type of doctor needed.
4. Ask: 'Would you like me to refer a doctor?'
Keep it short.
";

        return $this->askOpenAI($prompt);
    }

    // ------------------------------------------
    // 2. DOCTOR REFERRAL (DB)
    // ------------------------------------------
    private function referDoctorFromDB($msg)
    {
        // Extract specialization smartly using AI
        $specPrompt = "
Identify the medical specialization needed from this message:
\"$msg\"
Return only 1 word like: Cardiology, Neurology, Dermatology, Pediatrics, General Medicine.
";

        $spec = trim($this->askOpenAI($specPrompt));

        $doctors = Doctor::where('specialization', 'LIKE', "%$spec%")->get();

        if ($doctors->isEmpty()) {
            return "I couldn't find any **$spec** specialists in the hospital.";
        }

        $list = "";
        foreach ($doctors as $d) {
            $list .= "- Dr. {$d->user->name} ({$d->specialization})\n";
        }

        return "
Here are the available **$spec** doctors:\n$list
If you want to check availability, type:  
**check Dr. Name**
";
    }

    // ------------------------------------------
    // 3. CHECK DOCTOR AVAILABLE TIMES
    // ------------------------------------------
    private function doctorAvailability($msg)
    {
        preg_match('/dr\.?\s*([a-zA-Z ]+)/i', $msg, $match);

        if (!isset($match[1])) {
            return "Please specify the doctor name.";
        }

        $name = trim($match[1]);

        $doctor = Doctor::whereHas('user', fn($q) =>
            $q->where('name', 'LIKE', "%$name%")
        )->first();

        if (!$doctor) {
            return "No doctor found under the name **Dr. $name**.";
        }

        $appts = Appointment::where('doctor_id', $doctor->id)
            ->where('date', '>=', now())
            ->orderBy('date')
            ->take(5)
            ->get();

        if ($appts->isEmpty()) {
            return "Dr. {$doctor->user->name} has no scheduled times.";
        }

        $slots = "";
        foreach ($appts as $a) {
            $slots .= "- {$a->date} at {$a->time}\n";
        }

        return "
Available times for **Dr. {$doctor->user->name}**:\n$slots
To book, type:  
**book Dr. {$doctor->user->name} on YYYY-MM-DD at HH:MM**
";
    }

    // ------------------------------------------
    // 4. BOOK APPOINTMENT
    // ------------------------------------------
    private function bookDoctor($msg)
    {
        preg_match('/book\s+dr\.?\s*([a-zA-Z ]+)\s*on\s*(\d{4}-\d{2}-\d{2})\s*at\s*([0-9:]+)/i', $msg, $m);

        if (count($m) < 4) {
            return "Use format:  
**book Dr. Name on 2025-01-10 at 09:00**";
        }

        $name = trim($m[1]);
        $date = $m[2];
        $time = $m[3];

        $doctor = Doctor::whereHas('user', fn($q) =>
            $q->where('name', 'LIKE', "%$name%")
        )->first();

        if (!$doctor) {
            return "Doctor not found.";
        }

        Appointment::create([
            "doctor_id" => $doctor->id,
            "patient_id" => Auth::id(),
            "date" => $date,
            "time" => $time,
            "status" => 'Pending'
        ]);

        return "✅ Appointment booked with **Dr. $name** on **$date at $time**.";
    }

    // ------------------------------------------
    // OpenAI Wrapper
    // ------------------------------------------
    private function askOpenAI($prompt)
    {
        try {
            $client = OpenAI::client(env('OPENAI_API_KEY'));

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are MediSync AI Assistant. Short, helpful answers.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.4
            ]);

            return trim($response->choices[0]->message->content);

        } catch (\Exception $e) {
            return "⚠️ AI Error: " . $e->getMessage();
        }
    }
}
