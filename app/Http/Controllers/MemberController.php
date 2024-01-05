<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                //here we will need to check if they are admin/mod or member
                $discussions = Discussion::where('member',$memberID)->orderBy('updated_at', 'desc')->get();
                $m['discussions'] = $discussions;
                foreach ($discussions as $discussion) {
                    $dDateTime = $discussion->created_at;
                    $discussion['datetime'] = $dDateTime->toDayDateTimeString();
                    $discussion['content'] = Str::limit($discussion->content, 200, ' ...');
                }
                //here we will need to check if they are admin/mod or member
                $comments = Comment::where('member',$memberID)->orderBy('updated_at', 'desc')->get();
                $m['comments'] = $comments;
                foreach ($comments as $comment) {
                    $discussionID = $comment->discussion;
                    $discussion = Discussion::where('id',$discussionID)->get();
                    $comment['discussion'] = $discussion;
                    $cDateTime = $comment->created_at;
                    $comment['datetime'] = $cDateTime->toDayDateTimeString();
                    $comment['content'] = Str::limit($comment->content, 200, ' ...');
                }
            }
			return view('member', compact('member'));
    	} else {
    		return redirect('/');
    	}

    }
}
