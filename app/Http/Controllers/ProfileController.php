<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileCreateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the on Onboarding page
     */
    public function create() {
        $authUser = Auth::user();

        $user = User::find($authUser->id);

        if ($user && $user->is_first_time) {

            $user->update(['is_first_time' => false]);

            return Inertia::render('Profile/Create');
        }

        return redirect()->intended(route('dashboard', absolute: false));

    }

    public function store(ProfileCreateRequest $request)
    {
        $fields = $request->validated();

        try {
            DB::beginTransaction();

            $profile = $request->user()->profile()->create([
                'business_name' => $fields['business_name'],
                'business_model' => $fields['business_model'],
                'industry' => $fields['industry'],
                'description' => $fields['description'],
                'target_audience' => $fields['target_audience'],
                'unique_selling_point' => $fields['unique_selling_point'],
                'location' => $fields['location'],
                'phone_number' => $fields['phone_number'] ?? null,
                'website_url' => $fields['website_url'],
            ]);

            if (isset($fields['social_links'])) {
                $profile->socialLinks()->createMany(
                    collect($fields['social_links'])->map(function ($socialLink) {
                        return [
                            'platform' => $socialLink['platform'],
                            'link' => $socialLink['link'],
                        ];
                    })->toArray()
                );
            }

            DB::commit();

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong while creating your profile. Please try again.']);
        }
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
