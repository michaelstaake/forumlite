<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Discussion;
use App\Models\Category;

class WatchedController extends Controller
{
    public function show() {
    	if (Auth::check()) {
            $userid = Auth::user()->id;
            $watched = DB::table('watched')->where('member', $userid)->get();
            foreach ($watched as $w) {
                $discID = $w->discussion;
                $discussion = Discussion::where('id',$discID)->get();
                $w->discussion = $discussion;
                $catID = $discussion->category;
                
            }

            
    		return view('watched', compact('watched'));
    	} else {
    		App::abort(401);
    	}
    }

    public function unwatch(UnwatchRequest $request)
    {
        $user = Auth::user()->username;
        $watch_id = $request->watch_id;
        $count = DB::table('watched')->where('member', $user)->where('id', $watch_id)->count();
        if ($count == 1) {
        	$deleted = DB::table('watched')->where('watch_id', $watch_id)->delete();
            return redirect('/settings');
        } else {
            return redirect('/settings');
        }

    }
}
