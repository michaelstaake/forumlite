<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ControlpanelSettingsSaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserAvatar;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Section;
use App\Models\Category;
use App\Models\Report;

class ControlPanelController extends Controller
{
    public function show($page = null) 
    {
    	if (Auth::check())
    		if (auth()->user()->group === "admin") {
	        	if ($page == null) {
	        		return view('controlpanel.controlpanel');
	        	} elseif ($page === "reports") {
	        		return view('controlpanel.reports');
	        	} elseif ($page === "users") {
	        		$users = User::all();
	        		return view('controlpanel.users', compact('users'));
	        	} elseif ($page === "settings") {
	        		$settings = Settings::all();
	        		return view('controlpanel.settings', compact('settings'));
	        	} elseif ($page === "categories") {
	        		$sections = Section::all();
			    	$categories = Category::all();
			    	return view('controlpanel.categories', compact('sections'), compact('categories'));
				} else {
	        		App::abort(404);
	        	}
			} else if (auth()->user()->group === "mod") {
				if ($page == null) {
	        		return view('controlpanel.controlpanel');
	        	} elseif ($page === "reports") {
	        		return view('controlpanel.reports');
	        	} elseif ($page === "users") {
	        		$users = User::all();
	        		return view('controlpanel.users', compact('users'));
	        	} else {
	        		App::abort(404);
	        	}
			} else {
	        	App::abort(403);
			}
    	else
    		App::abort(403);

    	
    }

    public function showUser($user = null) 
    {
    	if (Auth::check()) {
    		if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$count = DB::table('users')->where('username', $user)->count();
    			if ($count == 1) {
					if (auth()->user()->username == $user) {
						abort(403);
					} else {
						$member = User::where('username', $user)->get();
						foreach ($member as $m) {
							$mDateTimeCreated = $m->created_at;
							$m['dateTimeCreated'] = $mDateTimeCreated->toDayDateTimeString();
							$mDateTimeActive = $m->created_at;
							$m['dateTimeActive'] = $mDateTimeActive->toDayDateTimeString();
							$memberID = $m->id;
							$numDiscussions = DB::table('discussions')->where('member', $memberID)->count();
							$m['numDiscussions'] = $numDiscussions;
							$numComments = DB::table('comments')->where('member', $memberID)->count();
							$m['numComments'] = $numComments;
						}
						$avatars = UserAvatar::where('user', $user)->get();
						return view('controlpanel.user', compact('member', 'avatars'));
					}
					
				} else {
	        		abort(404);
	        	}
			} else {
	        	abort(403);
			}
		} else {
    		abort(403);
		}

    	
    }

	public function showReport($report = null) 
    {
    	if (Auth::check()) {
    		if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$count = DB::table('reports')->where('id', $report)->count();
    			if ($count == 1) {
					$report = Report::where('id', $report)->get();
					return view('controlpanel.report', compact('report'));
					
				} else {
	        		abort(404);
	        	}
			} else {
	        	abort(403);
			}
		} else {
    		abort(403);
		}

    	
    }

	public function settingsSubmit(ControlPanelSettingsSaveRequest $request) 
	{
		DB::table('pages')->where('page', 'terms')->update(['content' => $request->terms]);
		DB::table('pages')->where('page', 'privacy')->update(['content' => $request->privacy]);
       return redirect('/controlpanel/settings');
	}
		


}
