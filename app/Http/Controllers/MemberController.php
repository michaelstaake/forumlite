<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Discussion;
use App\Models\Comment;

class MemberController extends Controller
{
    public function show($username = null) {
    	$count = DB::table('users')->where('username', $username)->count();
    	if ($count == 1) {
    		$member = User::where('username', $username)->get();
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
                if (Auth::check()) {
                    if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
                        $discussions = Discussion::where('member', $memberID)->orderBy('updated_at', 'desc')->get();
                    } else {
                        $discussions = Discussion::where('member', $memberID)->where('is_hidden', FALSE)->orderBy('updated_at', 'desc')->get();
                    }
                } else {
                    $discussions = Discussion::where('member', $memberID)->where('is_hidden', FALSE)->orderBy('updated_at', 'desc')->get();
                }
                $m['discussions'] = $discussions;
                foreach ($discussions as $discussion) {
                    $dDateTime = $discussion->created_at;
                    $discussion['datetime'] = $dDateTime->toDayDateTimeString();
                    $discussion['content'] = Str::limit($discussion->content, 200, ' ...');
                }
                if (Auth::check()) {
                    if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
                        $comments = Comment::where('member', $memberID)->orderBy('updated_at', 'desc')->get();
                    } else {
                        $comments = Comment::where('member', $memberID)->where('is_hidden', FALSE)->orderBy('updated_at', 'desc')->get();
                    }
                } else {
                    $comments = Comment::where('member', $memberID)->where('is_hidden', FALSE)->orderBy('updated_at', 'desc')->get();
                }
                foreach ($comments as $comment) {
                    $discussionID = $comment->discussion;
                    $discussion = Discussion::where('id',$discussionID)->get();
                    foreach ($discussion as $disc) {
                        if ($disc->is_hidden == TRUE) {
                            $comment['is_hidden'] = TRUE;
                        }
                    }
                    $comment['discussion'] = $discussion;
                    $cDateTime = $comment->created_at;
                    $comment['datetime'] = $cDateTime->toDayDateTimeString();
                    $comment['content'] = Str::limit($comment->content, 200, ' ...');
                }
                $m['comments'] = $comments->where('is_hidden', FALSE);
            }
			return view('member', compact('member'));
    	} else {
    		return redirect('/');
    	}

    }
}
