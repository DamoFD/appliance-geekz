<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitlist;

class WaitlistController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|min:3|string',
            'email' => 'required|email|unique:waitlists,email',
        ]);

        Waitlist::create($validated);

        return redirect()->route('home')->with('success', 'You have been added to the waitlist!');
    }
}
