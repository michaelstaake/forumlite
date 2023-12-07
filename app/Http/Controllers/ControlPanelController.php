<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ControlPanelSettingsSaveRequest;
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
	        		$maintenance_mode = Settings::where('setting', 'maintenance_mode')->first();
					$maintenance_mode = $maintenance_mode->value;
					$maintenance_message = Settings::where('setting', 'maintenance_message')->first();
					$maintenance_message = $maintenance_message->value;
					$can_register = Settings::where('setting', 'can_register')->first();
					$can_register = $can_register->value;
					$can_signature = Settings::where('setting', 'can_signature')->first();
					$can_signature = $can_signature->value;
					$contact_type = Settings::where('setting', 'contact_type')->first();
					$contact_type = $contact_type->value;
					$contact_link = Settings::where('setting', 'contact_link')->first();
					$contact_link = $contact_link->value;
					$header = Settings::where('setting', 'header')->first();
					$header = $header->value;
					$footer = Settings::where('setting', 'footer')->first();
					$footer = $footer->value;
					$terms_content = DB::table('pages')->where('page', 'terms')->first();
					$terms_content = $terms_content->content;
					$privacy_content = DB::table('pages')->where('page', 'privacy')->first();
					$privacy_content = $privacy_content->content;
					$header_content = DB::table('integrations')->where('element', 'header')->first();
					$header_content = $header_content->content;
					$footer_content = DB::table('integrations')->where('element', 'footer')->first();
					$footer_content = $footer_content->content;
					return view('controlpanel.settings')->with('maintenance_mode', $maintenance_mode)->with('maintenance_message', $maintenance_message)->with('can_register', $can_register)->with('can_signature', $can_signature)->with('contact_type', $contact_type)->with('contact_link', $contact_link)->with('header', $header)->with('footer', $footer)->with('terms_content', $terms_content)->with('privacy_content', $privacy_content)->with('header_content', $header_content)->with('footer_content', $footer_content);
	        	} elseif ($page === "categories") {
	        		$sections = Section::all();
			    	$categories = Category::all();
			    	return view('controlpanel.categories', compact('sections'), compact('categories'));
				} else {
	        		abort(404);
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
	        		abort(404);
	        	}
			} else {
	        	abort(403);
			}
    	else
    		abort(403);

    	
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
		DB::table('pages')->where('page', 'terms')->update(['content' => $request->terms_content]);
		DB::table('pages')->where('page', 'privacy')->update(['content' => $request->privacy_content]);
		DB::table('integrations')->where('element', 'header')->update(['content' => $request->header_content]);
		DB::table('integrations')->where('element', 'footer')->update(['content' => $request->footer_content]);
		DB::table('settings')->where('setting', 'maintenance_mode')->update(['value' => $request->maintenance_mode]);
		DB::table('settings')->where('setting', 'maintenance_message')->update(['value' => $request->maintenance_message]);
		DB::table('settings')->where('setting', 'can_register')->update(['value' => $request->can_register]);
		DB::table('settings')->where('setting', 'can_signature')->update(['value' => $request->can_signature]);
		DB::table('settings')->where('setting', 'contact_type')->update(['value' => $request->contact_type]);
		DB::table('settings')->where('setting', 'contact_link')->update(['value' => $request->contact_link]);
		DB::table('settings')->where('setting', 'header')->update(['value' => $request->header]);
		DB::table('settings')->where('setting', 'footer')->update(['value' => $request->footer]);

       return redirect('/controlpanel/settings');
	}
		


}
