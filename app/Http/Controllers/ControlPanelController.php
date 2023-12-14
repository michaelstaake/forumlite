<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ControlPanelSettingsSaveRequest;
use App\Http\Requests\ControlPanelUserModifyActionRequest;
use App\Http\Requests\ControlPanelCategoryDeleteRequest;
use App\Http\Requests\ControlPanelCategoryManageRequest;
use App\Http\Requests\ControlPanelCategoryNewRequest;
use App\Http\Requests\ControlPanelSectionDeleteRequest;
use App\Http\Requests\ControlPanelSectionManageRequest;
use App\Http\Requests\ControlPanelSectionNewRequest;
use App\Http\Requests\ReportHandleRequest;
use App\Http\Requests\ReportDeleteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
    /* Control Panel: Show Pages */
	
	public function show($page = null) 
    {
    	if (Auth::check())
    		if (auth()->user()->group === "admin") {
	        	if ($page == null) {
	        		return view('controlpanel.controlpanel');
	        	} elseif ($page === "reports") {
	        		$rn = Report::where('status','new')->orderBy('id', 'desc')->get();
					$rh = Report::where('status','handled')->orderBy('id', 'desc')->get();
	        		return view('controlpanel.reports', compact('rn'), compact('rh'));
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
					$rn = Report::where('status','new')->orderBy('id', 'desc')->get();
					$rh = Report::where('status','handled')->orderBy('id', 'desc')->get();
	        		return view('controlpanel.reports', compact('rn'), compact('rh'));
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

	/* User: Show */

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

	/* User: Save */

	public function userSubmit(ControlPanelUserModifyActionRequest $request)
    {
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$username = $request->username;
				$user_id = $request->user_id;
				$count = DB::table('users')->where('id', $user_id)->count();
				if ($count == 1) {
					$user = User::find($user_id);
					$user->email = $request->email;
					$user->avatar = $request->avatar;
        			$user->signature = $request->signature;
        			$user->location = $request->location;
					$user->save();
					$url = '/controlpanel/user/'.$username;
        			return redirect($url);
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

	/* User: Change Group */

	public function userModifyGroup(ControlPanelUserModifyActionRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$username = $request->username;
				$user_id = $request->user_id;
				$count = DB::table('users')->where('id', $user_id)->count();
				if ($count == 1) {
					$user = User::find($user_id);
					$user->group = $request->group;
					$user->save();
					$url = '/controlpanel/user/'.$username;
        			return redirect($url);
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

	/* User: Ban */

	public function userBan(ControlPanelUserModifyActionRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$username = $request->username;
				$user_id = $request->user_id;
				$count = DB::table('users')->where('id', $user_id)->count();
				if ($count == 1) {
					$user = User::find($user_id);
					$user->is_banned = TRUE;
					$user->save();
					$url = '/controlpanel/user/'.$username;
        			return redirect($url);
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

	/* User: Unban */

	public function userUnban(ControlPanelUserModifyActionRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$username = $request->username;
				$user_id = $request->user_id;
				$count = DB::table('users')->where('id', $user_id)->count();
				if ($count == 1) {
					$user = User::find($user_id);
					$user->is_banned = FALSE;
					$user->save();
					$url = '/controlpanel/user/'.$username;
        			return redirect($url);
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

	/* User: Delete Avatar */

	public function userDeleteAvatar(ControlPanelUserModifyActionRequest $request)
    {
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$username = $request->username;
				$filename = $request->avatar;
				$count1 = DB::table('users')->where('username', $username)->count();
				if ($count1 == 1) {
					$count2 = DB::table('avatars')->where('user', $username)->where('filename', $filename)->count();
					if ($count2 == 1) {
						$delete = UserAvatar::where('filename', $filename)->delete();
						Storage::delete('public/avatars/'.$filename);
						$url = '/controlpanel/user/'.$username;
        				return redirect($url);
					} else {
						abort(404);
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

	/* Categories: Section: New */

	public function sectionNew(ControlPanelSectionNewRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$name = $request->name;
				$slug = Str::slug($name, '-');
				$order = rand(100000, 999999);
				$sectionCreate = Section::create([
					'name' => $name,
					'slug' => $slug,
					'order' => $order,
				]);
				return redirect('/controlpanel/categories');
			} else {
	        	abort(403);
			}
		} else {
			abort(403);
		}
	}

	/* Categories: Section: Manage */

	public function sectionManage(ControlPanelSectionManageRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$section_id = $request->section_id;
				$count = DB::table('sections')->where('id', $section_id)->count();
				if ($count == 1) {
					$section = Section::find($section_id);
					$section->name = $request->name;
					$section->save();
					return redirect('/controlpanel/categories');
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

	/* Categories: Section: Delete */

	public function sectionDelete(ControlPanelSectionDeleteRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin") {
				$section_id = $request->section_id;
				$count1 = DB::table('sections')->where('id', $section_id)->count();
				if ($count1 == 1) {
					$count2 = DB::table('categories')->where('section', $section_id)->count();
					if ($count2 == 0) {
						$section = Section::find($section_id);
						$section->delete();
						return redirect('/controlpanel/categories');
					} else {
						abort(500);
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

	/* Categories: Category: New */

	public function categoryNew(ControlPanelCategoryNewRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$section = $request->section;
				$name = $request->name;
				$description = $request->description;
				$slug = Str::slug($name, '-');
				$order = rand(100000, 999999);
				$is_readonly = FALSE;
				$is_hidden = FALSE;
				$categoryCreate = Category::create([
					'section' => $section,
					'name' => $name,
					'description' => $description,
					'slug' => $slug,
					'order' => $order,
					'is_readonly' => $is_readonly,
					'is_hidden' => $is_hidden,
				]);
				return redirect('/controlpanel/categories');
			} else {
	        	abort(403);
			}
		} else {
			abort(403);
		}
	}

	/* Categories: Category: Manage */

	public function categoryManage(ControlPanelCategoryManageRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$category_id = $request->category_id;
				$count = DB::table('categories')->where('id', $category_id)->count();
				if ($count == 1) {
					$category = Category::find($category_id);
					$category->name = $request->name;
					$category->slug = Str::slug($request->name, '-');
					$category->save();
					return redirect('/controlpanel/categories');
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

	/* Categories: Category: Delete */

	public function categoryDelete(ControlPanelCategoryDeleteRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin") {
				$category_id = $request->category_id;
				$do_what_with_discussions = $request->do_what_with_discussions;
				$count1 = DB::table('categories')->where('id', $category_id)->count();
				if ($count1 == 1) {
					if ($do_what_with_discussions == "delete") {
						$discussions = Discussion::where('category', $category_id)->get();
						foreach ($discussions as $d) {
							$discussion_id = $d->id;
							$comments = Comment::where('discussion', $discussion_id)->get();
							foreach ($comments as $c) {
								$comment_id = $c->id;
								$comment = Comment::find($comment_id);
								$comment->delete();
							}
							$discussion = Discussion::find($discussion_id);
							$discussion->delete();
						}
						$category = Category::find($category_id);
						$category->delete();
						return redirect('/controlpanel/categories');
					} else {
						$count2 = DB::table('categories')->where('id', $do_what_with_discussions)->count();
						if ($count2 == 1) {
							$discussions = Discussion::where('category', $category_id)->get();
							foreach ($discussions as $d) {
								$discussion_id = $d->id;
								$discussion = Discussion::find($discussion_id);
								$discussion->category = $do_what_with_discussions;
								$discussion->save();
								$comments = Comment::where('discussion', $discussion_id)->get();
								foreach ($comments as $c) {
									$comment_id = $c->id;
									$comment = Comment::find($comment_id);
									$comment->category = $do_what_with_discussions;
									$comment->save();
								}
							}
						} else {
							abort(500);
						}
						$category = Category::find($category_id);
						$category->delete();
						return redirect('/controlpanel/categories');
					}
				} else {
	        		abort(500);
	        	}
			} else {
	        	abort(403);
			}
		} else {
			abort(403);
		}
	}

	/* Report: Show */

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

	/* Report: Handle */
	
	public function reportHandle(ReportHandleRequest $request) 
	{
		Report::where('id', $request->report_id)->update(['status' => 'handled']);
		return redirect('/controlpanel/report/'.$request->report_id);
	}

	/* Report: Delete */

	public function reportDelete(ReportDeleteRequest $request) 
	{
		Report::where('id', $request->report_id)->delete();
		return redirect('/controlpanel/reports');
	}

	/* Settings: Save */

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
