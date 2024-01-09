<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;


class NotificationsController extends Controller
{
    public function show() {
    	if (Auth::check()) {
    		$notifications = Notification::where('member', auth()->user()->id)->get();
    		foreach ($notifications as $notification) {
	        	$notifType = $notification->id;
	        	if ($notifType = "comment"){
					$notification['typeFriendly'] = "New Comment";
	        	} else if ($notifType = "message") {
					$notification['typeFriendly'] = "New Message";
	        	} else if ($notifType = "report") {
					$notification['typeFriendly'] = "New Report";
	        	} else {
	        	}
	        }
			$notifications = $notifications->sortByDesc('created_at')->paginate(15);
    		return view('notifications', compact('notifications'));
    	} else {
    		App::abort(401);
    	}
    }

	public function view($notification = null) {
		if (Auth::check()) {
			$count = DB::table('notifications')->where('id', $notification)->where('member', auth()->user()->id)->count();
        	if ($count == 1) {
				$notification = Notification::where('id', $notification)->first();
				$notification->status = "read";
				$notification->save();
				return redirect($notification->link);
			} else {
				App::abort(404);
			}
		} else {
			App::abort(401);
		}
	}

    public function clear() {
    	if (Auth::check()) {
    		$clearNotifications = Notification::where('member', auth()->user()->id)->delete();
    		return redirect('/notifications');
    	} else {
    		App::abort(401);
    	}
    }
}
