<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationController extends Controller
{
    public function show()
    {
        return Inertia::render('Profile/UpdateVerification');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        // Simple verification logic
        if ($request->code === '123456') {
            return redirect()->route('profile.edit')->with('success', 'Verification successful');
        }

        return back()->withErrors(['code' => 'Invalid verification code']);
    }
}
