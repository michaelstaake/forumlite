<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BadgeController extends Controller
{
    public function getBadges()
    {	
    	$user = auth()->user()->id;
    	$countNotifications = DB::table('notifications')->where('member', $user)->where('status', 'unread')->count();
    	$countMessages = DB::table('messages')->where('to', $user)->where('status', 'unread')->count();
    	$countReports = DB::table('reports')->where('status', 'new')->count();
        return response()->json([
        	'numNotifications'=> $countNotifications,
        	'numMessages'=> $countMessages,
        	'numReports'=> $countReports
    ]);
    }
}
