<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the on Onboarding page
     */
    public function create() {
        return Inertia::render('Profile/Create');

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

    public function edit() {
        $user = Auth::user();

        $profile = $user->profile;

        $socialLinks = $profile->socialLinks()->get();

        return Inertia::render('Profile/Edit', [
            'profile' => $profile,
            'socialLinks' => $socialLinks
        ]);
    }


    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone_number' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        // Handle profile image upload if exists
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
            $user->save();
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
    public function verifyUpdate(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        // Implement your verification logic here
        // For example, check against a stored verification code
        
        if ($this->validateVerificationCode($request->code)) {
            // Verification successful
            return redirect()->route('profile.edit')->with('success', 'Verification successful');
        }

        // Verification failed
        return back()->withErrors(['code' => 'Invalid verification code']);
    }

    private function validateVerificationCode($code)
    {
        // Implement your verification logic
        // This could involve checking against a stored code in the database
        // or using a service like email verification
        return $code === '123456'; // Example placeholder
    }
    public function resendVerification(Request $request)
    {
        $user = Auth::user();

        // Generate a new verification code
        $verificationCode = Str::random(6);

        // Store the new verification code in the user's session
        $request->session()->put('profile_update_verification_code', $verificationCode);
        $request->session()->put('profile_update_verification_expires_at', now()->addMinutes(10));

        // Send verification email
        Mail::to($user->email)->send(new ProfileUpdateVerificationMail($verificationCode));

        return response()->json([
            'message' => 'Verification code has been resent to your email.'
        ]);
    }
}





