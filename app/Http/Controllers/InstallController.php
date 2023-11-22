<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public function show() {
    	$version = DB::table('settings')->select('setting', 'value')->first();
    	$version = $version->value;
        if ($version >= '100') {
        	rApp::abort(403);
        } else {
        	return view('install');
        }
    }
}
