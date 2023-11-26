<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StartController extends Controller
{
    public function show() {
        $version = '001';
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

    public function install() {
        return 'install failed';
    }

    public function update() {
        return 'update failed';
    }
}
