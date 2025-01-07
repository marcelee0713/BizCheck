<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ChangeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EmailChangeController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/ChangeEmail');
    }

    public function store(Request $request)
    {
        $body = $request->validate([
            'email' => ['email', 'required', 'string', 'max:255']
        ]);

        $user = $request->user();

        $token = Str::random(60);

        if ($user->email == $body['email']) {
            return back()->with(['error' => 'You can not change your email when it is the same.']);
        }

        $existingToken = DB::table('change_email_tokens')
            ->where('email', $body['email'])
            ->first();

        if ($existingToken) {
            $createdAt = Carbon::parse($existingToken->created_at);
            $expirationTime = $createdAt->addMinutes(60);

            if (Carbon::now()->lessThan($expirationTime)) {
                return back()->with(['error' => 'A verification request for this email already exists. Please wait for the current token to expire.']);
            }

            DB::table('change_email_tokens')
                ->where('email', $body['email'])
                ->delete();
        }


        DB::table('change_email_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $verificationLink = URL::temporarySignedRoute(
            'change_email.verify',
            now()->addMinutes(60),
            ['token' => $token, 'email' => $body['email']]
        );

        Mail::to($user->email)->send(new ChangeEmail($user, $verificationLink));

        return Inertia::render('Auth/ChangeEmail',[
            'status' => 'Verification email sent to your new address.',
        ]);
    }

    public function verify(Request $request, $token, $email)
    {
        $currEmail = $request->user()->email;

        if (!$request->hasValidSignature()) {
            return Inertia::render('Auth/ChangeEmailVerify', [
                'error' => 'Invalid or tampered token.'
            ]);
        }

        $tokenRecord = DB::table('change_email_tokens')->where('email', $currEmail)->where('token', $token)->first();

        if (!$tokenRecord) {
            return Inertia::render('Auth/ChangeEmailVerify', [
                'error' => 'This request does not exist.'
            ]);
        }

        $createdAt = Carbon::parse($tokenRecord->created_at);
        $expirationTime = $createdAt->addMinutes(60);

        if (Carbon::now()->greaterThan($expirationTime)) {
            return Inertia::render('Auth/ChangeEmailVerify', [
                'error' => 'This token have been expired.'
            ]);
        }


        $user = User::where('email', $currEmail)->first();

        if (!$user) {
            return Inertia::render('Auth/ChangeEmailVerify', [
                'error' => 'User not found.'
            ]);
        }

        $user->email = $email;
        $user->email_verified_at = null;

        $user->save();

        $user->sendEmailVerificationNotification();

        DB::table('change_email_tokens')->where('email', $email)->where('token', $token)->delete();

        DB::table('sessions')->where('user_id', $user->id)->delete();

        Auth::logout();

       return Inertia::render('Auth/Login', [
            'status' => "You've successfully changed your email address. We've also sent an email verification to your new email address."
        ]);
    }
}
