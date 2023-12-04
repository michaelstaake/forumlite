<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use App\Models\User;
use App\Models\Section;
use App\Models\Category;

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
				} elseif ($page === "pages") {
	        		return view('controlpanel.pages');
	        	} elseif ($page === "integrations") {
	        		return view('controlpanel.integrations');
	        	} elseif ($page === "backup") {
	        		return view('controlpanel.backup');
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

    public function showUser($page = null) 
    {
    	if (Auth::check())
    		if (auth()->user()->group === "admin" || auth()->user()->group === "mod")
	        	return view('controlpanel.user');
	        else
	        	App::abort(403);
    	else
    		App::abort(403);

    	
    }


}
