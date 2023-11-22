<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    		return view('notifications', compact('notifications'));
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
