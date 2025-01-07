<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialLinksController extends Controller
{
    public function update(Request $request)
    {
        $fields = $request->validate([
            'social_links' => ['nullable', 'array'],
            'social_links.*.platform' => ['required', 'string', 'max:255'],
            'social_links.*.link' => ['nullable', 'string', 'url', 'max:500'],
        ]);

        $user = $request->user();

        $profile = $user->profile;
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $socialLinks = $fields['social_links'] ?? [];

        foreach ($socialLinks as $link) {
            $profile->socialLinks()->updateOrCreate(
                ['platform' => $link['platform']],
                ['link' => $link['link'] ?? '']
            );
        }

        return back()->with(['message' => 'Social links updated successfully']);
    }

}
