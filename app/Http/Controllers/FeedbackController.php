<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all()->sortByDesc('created_at');
        return view('admin-feedback', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        return view('admin-show-feedback', compact('feedback'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ai_usage_id' => 'required|exists:ai_usages,id',
            'feedback' => 'required|string|max:255',
        ]);

        Feedback::create([
            'ai_usage_id' => $validated['ai_usage_id'],
            'feedback' => $validated['feedback'],
        ]);

        return response()->json(['message' => 'Feedback submitted successfully']);
    }
}
