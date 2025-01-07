<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = request()->user();

        $fields = $request->validate([
            'name' => ['string', 'required', 'max:255'],
            'removePic' => ['string', 'required'],
            'avatar' => ['nullable','file', 'image', 'mimes:jpg,jpeg,png' ,'max:10240'],

        ]);

        $oldAvatar = $user->avatar;

        try {
            DB::beginTransaction();

            if ($request->removePic == '1' && $user->avatar) {
                Storage::disk('public')->delete($user->avatar);

                $user->avatar = null;
            }

            if ($request->hasFile('avatar')) {

                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            $user->update([
                'name' => $fields['name'],
                'avatar' => $user->avatar,
            ]);

            DB::commit();

            return back()->with('message', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($avatarPath) && Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }

            if ($oldAvatar) {
                $user->avatar = $oldAvatar;
            }

            $user->save();

            return back()->withErrors(['error' => 'Something went wrong while updating your profile. Please try again.']);
        }
    }

}
