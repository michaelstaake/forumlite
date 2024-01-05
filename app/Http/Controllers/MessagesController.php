<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MessageRequest;
use App\Events\NewMessage;


class MessagesController extends Controller
{
    public function showMessages($m1 = null) 
    {
    	if (Auth::check()) {
    		if ($m1 == null) {
	    		return redirect('/messages/inbox');
    		} elseif ($m1 === "inbox") {
	    		$messages = Message::where('to', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
	    		foreach ($messages as $message) {
                    $userID = $message->from;
					$dateTime = $message->created_at;
                	$user = User::where('id',$userID)->get();
                	$message['user'] = $user;
                    $message['content'] = Str::limit($message->content, 200, ' ...');
					$message['datetime'] = $dateTime->toDayDateTimeString();
                }
	    		return view('messages.inbox',["folder"=>$m1], compact('messages'));
	    	} elseif ($m1 === "sent") {
	    		$messages = Message::where('from', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
	    		foreach ($messages as $message) {
                    $userID = $message->to;
					$dateTime = $message->created_at;
                	$user = User::where('id',$userID)->get();
                	$message['user'] = $user;
                    $message['content'] = Str::limit($message->content, 200, ' ...');
					$message['datetime'] = $dateTime->toDayDateTimeString();
                }
	    		return view('messages.sent',["folder"=>$m1], compact('messages'));
	    	} else {
	    		App::abort(404);
	    	}
		} else {
	    	App::abort(401);
		}
        
    }

    public function showMessage($m2 = null,$m2r = null) 
    {
    	if (Auth::check()) {
    		if ($m2 == null) {
	    		return redirect('/');
    		} elseif ($m2 === "new" && $m2r == null) {
	    		return view('messages.new');
	    	} elseif ($m2 === "new" && $m2r != null) {
				return view('messages.new')->with('recipient', $m2r);
	    	} else {
	    		$count = DB::table('messages')->where('id', $m2)->count();
	    		if ($count == 1) {
    				$message = Message::where('id', $m2)->get();
    				foreach ($message as $mess) {
	                    $userTo = $mess->to;
	                    $userFrom = $mess->from;
						$dateTime = $mess->created_at;
	                    if ($mess->to == auth()->user()->id) {
							$user = User::where('id',$userFrom)->get();
							$mess['user'] = $user;
							$mess['folder'] = "inbox";
							$markread = DB::table('messages')->where('id', $m2)->update(['status' => 'read']);
	                    } else {
	                    	$user = User::where('id',$userFrom)->get();
	                    	$mess['user'] = $user;
	                    	$recipients = User::where('id',$userTo)->get();
	                    	$mess['recipient'] = $recipients;
							$mess['folder'] = "sent";
	                    }
	                }
	    			return view('messages.message', compact('message'));
	    		} else {

	    		}
	    	}
	    } else {
	    	return redirect('/');
		}
        
    }

    public function submit(MessageRequest $request) {

    	$message = Message::create($request->validated());
    	event(new NewMessage($message));
        return redirect('/messages/sent');
    }
}
