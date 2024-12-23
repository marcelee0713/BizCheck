<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmissionController extends Controller
{
    public function create(Request $request) {

        $profile = $request->user()->profile;

        $socialLinks = $profile->socialLinks()->get();

        return Inertia::render("Submission", [
            'profile' => $profile,
            'socialLinks' => $socialLinks
        ]);
    }

    public function store(Request $request) {

    }

}
