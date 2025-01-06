<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileCreateRequest;
use App\Http\Requests\Profile\ProfileEditRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function onboard() {
        return Inertia::render('Onboard');

        $authUser = Auth::user();

        $user = User::find($authUser->id);

        if ($user && $user->is_first_time) {

            $user->update(['is_first_time' => false]);

            return Inertia::render('Onboard');
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
                'phone_number' => $fields['phone_number'],
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
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong while creating your profile. Please try again.']);
        }
    }

    public function edit() {
        $user = Auth::user();

        $profile = $user->profile;

        $socialLinks = $profile->socialLinks()->get();

        return Inertia::render('Profile/Edit', [
            'profile' => $profile,
            'socialLinks' => $socialLinks
        ]);
    }

    public function show() {
        $user = Auth::user();

        $profile = $user->profile;

        $socialLinks = $profile->socialLinks()->get();

        return Inertia::render('Profile/Profile', [
            'profile' => $profile,
            'socialLinks' => $socialLinks
        ]);
    }


    public function update(ProfileEditRequest $request)
    {
        $fields = $request->validated();

        $user = Auth::user();

        $profile = $user->profile;

        if (!$profile) {
            return back()->withErrors(['error' => 'No profile found for the current user.']);
        }

        try {
            DB::beginTransaction();

            $profile->update([
                'business_name' => $fields['business_name'],
                'business_model' => $fields['business_model'],
                'industry' => $fields['industry'],
                'description' => $fields['description'],
                'target_audience' => $fields['target_audience'],
                'unique_selling_point' => $fields['unique_selling_point'],
                'location' => $fields['location'],
                'phone_number' => $fields['phone_number'],
                'website_url' => $fields['website_url'],
            ]);


            DB::commit();

            return back()->with('message', 'Successfully updated your business profile!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong while creating your profile. Please try again.']);
        }

        return back()->with('success', 'Profile updated successfully');
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





