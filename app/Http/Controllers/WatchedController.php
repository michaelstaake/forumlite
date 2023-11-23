<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Discussion;
use App\Models\Category;
use App\Models\User;
use App\Models\Watched;
use App\Http\Requests\UnwatchRequest;

class WatchedController extends Controller
{
    public function show() {
    	if (Auth::check()) {
            $userID = Auth::user()->id;
            $watched = DB::table('watched')->where('member', $userID)->get();
            foreach ($watched as $w) {
                $discID = $w->discussion;
                $discussion = Discussion::where('id',$discID)->get();
                $w->discussion = $discussion;
                foreach ($discussion as $d) {
                    $catID = $d->category;
                    $authorID = $d->member;
                }
                $category = Category::where('id',$catID)->get();
                $w->category = $category;
                $author = User::where('id',$authorID)->get();
                $w->author = $author;
            }

            
    		return view('watched', compact('watched'));
    	} else {
    		App::abort(401);
    	}
    }

    public function watch($d = null)
    {
        $count = DB::table('discussions')->where('slug', $d)->count();
    	if ($count == 1) {
            $discussion = Discussion::where('slug',$d)->get();
            foreach ($discussion as $d) {
                $discID = $d->id;
                $discSlug = $d->slug;
            }
    		$userID = Auth::user()->id;
            $watched = new Watched;
            $watched->member = $userID;
            $watched->discussion = $discID;
            $watched->type = 'watched';
            $watched->save();

			$url = '/discussion/'.$discSlug;
            return redirect($url);
    	} else {
    		return redirect('/');
    	}
    }

    public function unwatch(UnwatchRequest $request)
    {
        $user = Auth::user()->username;
        $watch_id = $request->watch_id;
        $count = DB::table('watched')->where('member', $user)->where('id', $watch_id)->count();
        if ($count == 1) {
        	$deleted = DB::table('watched')->where('watch_id', $watch_id)->delete();
            return redirect('/watched');
        } else {
            return redirect('/watched');
        }

    }
}
