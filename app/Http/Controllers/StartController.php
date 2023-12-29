<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InstallRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserAvatar;
use App\Models\Settings;
use Carbon\Carbon;

class StartController extends Controller
{
    public function show() {
        $version = '001';
        $db_version = DB::table('settings')->where('setting', 'version')->first();
		$db_version = $db_version->value;
        $db_install_complete = DB::table('settings')->where('setting', 'install_complete')->first();
		$db_install_complete = $db_install_complete->value;
        if ($db_install_complete == 'yes') {
            if ($db_version >= $version) {
                abort(403);
            } else {
                if (Auth::check()) {
                    if (auth()->user()->group === "admin") {
                        return view('update');
                    }
                } else {
                    abort(403);
                }
            }
        } else {
            return view('install');
        }

        $count = DB::table('settings')->where('setting', 'version')->count();
        if ($count > 0) {
            $settings = DB::table('settings')->where('setting', 'version')->get();
            foreach ($settings as $setting) {
				$dbVersion = $setting->value;
			}
            if ($dbVersion >= $version) {
                return 'error: database version invalid';
            } else {
                return view('update');
            }
        } else {
            return view('install');
        }
    }

    public function install(InstallRequest $request) {

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

        DB::table('settings')->where('setting', 'maintenance_mode')->update(['value' => 'disabled']);
        DB::table('settings')->where('setting', 'install_complete')->update(['value' => 'yes']);

        event(new Registered($user));

        return redirect('/email/verify')->with('success', "Account successfully registered.");
    }

    public function update() {
        return 'update failed';
    }
}
