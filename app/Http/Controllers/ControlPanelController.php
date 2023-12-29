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
use Carbon\Carbon;

class ControlPanelController extends Controller
{
    /* Control Panel: Show Pages */
	
	public function show($page = null) 
    {
    	if (Auth::check())
    		if (auth()->user()->group === "admin") {
	        	if ($page == null) {
					$version = Settings::where('setting', 'version')->first();
					$version = $version->value;
					function addDecimals($string) {
						$result = '';
						$length = strlen($string);
						
						for ($i = 0; $i < $length; $i++) {
							$result .= $string[$i];
							
							if ($i < $length - 1) {
								$result .= '.';
							}
						}
						
						return $result;
					}

					$version = addDecimals($version); // Version 100 in db = 1.0.0 displayed.
	        		return view('controlpanel.controlpanel')->with('version', $version);
	        	} elseif ($page === "reports") {
	        		$rn = Report::where('status','new')->orderBy('id', 'desc')->get();
					foreach ($rn as $n) {
						$nDateTimeCreated = $n->created_at;
						$n['dateTimeCreated'] = $nDateTimeCreated->toDayDateTimeString();
						$nDateTimeUpdated = $n->updated_at;
						$n['dateTimeUpdated'] = $nDateTimeUpdated->toDayDateTimeString();
					}
					$rh = Report::where('status','handled')->orderBy('id', 'desc')->get();
					foreach ($rh as $h) {
						$hDateTimeCreated = $h->created_at;
						$h['dateTimeCreated'] = $hDateTimeCreated->toDayDateTimeString();
						$hDateTimeUpdated = $h->updated_at;
						$h['dateTimeUpdated'] = $hDateTimeUpdated->toDayDateTimeString();
					}
	        		return view('controlpanel.reports', compact('rn'), compact('rh'));
	        	} elseif ($page === "users") {
	        		$users = User::all();
					foreach ($users as $user) {
						$created_at = $user->created_at;
						$last_active = Carbon::parse($user->last_active);
						$user['created_datetime'] = $created_at->toDayDateTimeString();
						$user['active_datetime'] = $last_active->toDayDateTimeString();
					}
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
					$contact_email = Settings::where('setting', 'contact_email')->first();
					$contact_email = $contact_email->value;
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
					return view('controlpanel.settings')->with('maintenance_mode', $maintenance_mode)->with('maintenance_message', $maintenance_message)->with('can_register', $can_register)->with('can_signature', $can_signature)->with('contact_type', $contact_type)->with('contact_link', $contact_link)->with('contact_email', $contact_email)->with('header', $header)->with('footer', $footer)->with('terms_content', $terms_content)->with('privacy_content', $privacy_content)->with('header_content', $header_content)->with('footer_content', $footer_content);
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
							$mDateTimeActive = Carbon::parse($m->last_active);
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

	/* User: Delete */

	public function userDelete(ControlPanelUserModifyActionRequest $request) 
	{
		if (Auth::check()) {
			if (auth()->user()->group === "admin") {
				$username = $request->username;
				$user_id = $request->user_id;
				$count1 = DB::table('users')->where('id', $user_id)->count();
				if ($count1 == 1) {
					$count2 = DB::table('discussions')->where('member', $user_id)->count();
					if ($count2 > 0) {
						abort(500);
					} else {
						$count3 = DB::table('comments')->where('member', $user_id)->count();
						if ($count3 > 0) {
							abort(500);
						} else {
							$count4 = DB::table('messages')->where('from', $user_id)->orWhere('to', $user_id)->count();
							if ($count4 > 0) {
								abort(500);
							} else {
								$count5 = DB::table('reports')->where('who_reported', $shovenose)->count();
								if ($count5 > 0) {
									abort(500);
								} else {
									$user = User::find($user_id);
									$user->delete();
									$url = '/controlpanel/users';
									return redirect($url);
								}
							}
						}
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
				$order = $request->order;
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
				$name = $request->name;
				$slug = Str::slug($name, '-');
				$order = $request->order;
				$count = DB::table('sections')->where('id', $section_id)->count();
				if ($count == 1) {
					$section = Section::find($section_id);
					$section->name = $name;
					$section->slug = $slug;
					$section->order = $order;
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
				$order = $request->order;
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
				$name = $request->name;
				$slug = Str::slug($name, '-');
				$order = $request->order;
				$description = $request->description;
				$count = DB::table('categories')->where('id', $category_id)->count();
				if ($count == 1) {
					$category = Category::find($category_id);
					$category->name = $name;
					$category->slug = $slug;
					$category->order = $order;
					$category->description = $description;
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
					foreach ($report as $r) {
						$rDateTimeCreated = $r->created_at;
						$r['dateTimeCreated'] = $rDateTimeCreated->toDayDateTimeString();
						$rDateTimeUpdated = $r->updated_at;
						$r['dateTimeUpdated'] = $rDateTimeUpdated->toDayDateTimeString();
					}
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
		DB::table('settings')->where('setting', 'contact_email')->update(['value' => $request->contact_email]);
		DB::table('settings')->where('setting', 'header')->update(['value' => $request->header]);
		DB::table('settings')->where('setting', 'footer')->update(['value' => $request->footer]);

       return redirect('/controlpanel/settings');
	}


}
