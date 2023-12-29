<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\Storage;
use App\Models\UserAvatar;
use App\Models\Settings;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Display register page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (Settings::where('setting', 'can_register')->value('value') != 'yes') {
            return view('register')->with('error', "can_register_false");
        } else {
            return view('register');
        }
    }

    /**
     * Handle account registration request
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request) 
    {
        if (Settings::where('setting', 'can_register')->value('value') != 'yes') {
            return redirect('/register')->with('error', "can_register_false");
        } else {
            $user = User::create($request->validated());

            auth()->login($user);

            $username = auth()->user()->username;
            $avatarUsername = Str::slug($username, '-');
            $avatarFileName = Str::slug($username, '-').'-default.png';
            $avatar = new Avatar();
            $avatar->create($avatarUsername)->setTheme('colorful')->setShape('square')->setDimension(200)->setFontSize(120)->save('storage/avatars/'.$avatarFileName);
            $avatarCreate = UserAvatar::create([
                'user' => $username,
                'filename' => $avatarFileName
            ]);

            $timestamp = Carbon::now()->format('Y-m-d H:i:m');
            $lastactive = User::where('id', auth()->user()->id)->update(['last_active' => $timestamp]);

            event(new Registered($user));

            return redirect('/email/verify')->with('success', "Account successfully registered.");
        }
        
    }

}