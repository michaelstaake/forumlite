<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsSubmitRequest;
use App\Http\Requests\AvatarUploadRequest;
use App\Http\Requests\AvatarDeleteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserAvatar;
use App\Models\Settings;


class SettingsController extends Controller
{
    public function show() {
    	if (Auth::check()) {
            if (Settings::where('setting', 'can_signature')->value('value') != 'yes') {
                $can_signature = 'FALSE';
            } else {
                $can_signature = 'TRUE';
            }
            $username = Auth::user()->username;
            $avatars = UserAvatar::where('user', $username)->get();
    		return view('settings', compact('avatars'))->with('can_signature', $can_signature);
    	} else {
    		App::abort(401);
    	}
    }

    public function submitSettings(SettingsSubmitRequest $request)
    {
        $userID = Auth::user()->id;
        $user = User::find($userID);
        $user->avatar = $request->avatar;
        $user->signature = $request->signature;
        $user->location = $request->location;
        $user->wants_emails_my_discussions = $request->wants_emails_my_discussions;
        $user->wants_emails_watched_discussions = $request->wants_emails_watched_discussions;
        $user->save();
        return redirect('/settings');

    }

    public function uploadAvatar(AvatarUploadRequest $request)
    {
        if($request->hasFile('avatarFile')) {
            $username = Auth::user()->username;
            $avatarFile = $request->file('avatarFile');
            $extension = $avatarFile->extension();
            $avatarFileName = Str::slug($username, '-').'-'.rand(100000, 999999).'.'.$extension;
            $uploadAvatar = $avatarFile->storeAs('public/avatars/'.$avatarFileName);
            $avatarCreate = UserAvatar::create([
                'user' => $username,
                'filename' => $avatarFileName
            ]);
            return redirect('/settings');
        } else {
            return redirect('/settings');
        }
    }

    public function DeleteAvatar(AvatarDeleteRequest $request)
    {
        $user = Auth::user()->username;
        $filename = $request->avatar;
        $count = DB::table('avatars')->where('user', $user)->where('filename', $filename)->count();
        if ($count == 1) {
            $delete = UserAvatar::where('filename', $filename)->delete();
            Storage::delete('public/avatars/'.$filename);
            return redirect('/settings');
        } else {
            return redirect('/settings');
        }

    }


}
