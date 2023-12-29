<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewDiscussionRequest;
use App\Http\Requests\ManageDiscussionRequest;
use App\Http\Requests\NewCommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;
use App\Models\Section;
use App\Models\Watched;
use App\Models\Settings;
use Carbon\Carbon;
use App\Jobs\NewReplyMail;

class DiscussionController extends Controller
{

    /* show existing discussion */

    public function show($slug = null) {
        $count = DB::table('discussions')->where('slug', $slug)->count();
        if ($count == 1) {
            if (Settings::where('setting', 'can_signature')->value('value') != 'yes') {
                $can_signature = 'FALSE';
            } else {
                $can_signature = 'TRUE';
            }
            $discussions = Discussion::where('slug',$slug)->get();
            foreach ($discussions as $discussion) {
                $discID = $discussion->id;
                $userID = $discussion->member;
                $user = User::where('id',$userID)->get();
                $discussion['user'] = $user;
                $catID = $discussion->category;
                $category = Category::where('id',$catID)->get();
                $discussion['category'] = $category;
                foreach ($category as $cat) {
                    $secID = $cat->section;
                    $section = Section::where('id',$secID)->get();
                    $discussion['section'] = $section;
                }
                $dDateTime = $discussion->created_at;
                $discussion['datetime'] = $dDateTime->toDayDateTimeString();
                $discViews = $discussion->views;
                $discViewsPlus = $discViews + 1;
                $updateViewCounter = DB::table('discussions')->where('slug', $slug)->update(['views' => $discViewsPlus]);
                if (Auth::check()) {
                    $currentUser = Auth::user()->id;
                    if ($discussion->member == $currentUser) {
                        $discussion['can_watch'] = 'FALSE';
                    } else {
                        $count_watched = DB::table('watched')->where('member', $currentUser)->where('discussion', $discID)->count();
                        if ($count_watched > 0) {
                            $discussion['can_watch'] = 'FALSE';
                        } else {
                            $discussion['can_watch'] = 'TRUE';
                        }
                    }
                }
            }
            $comments = Comment::where('discussion',$discID)->paginate(10);
            foreach ($comments as $comment) {
                $userID = $comment->member;
                $user = User::where('id',$userID)->get();
                $comment['user'] = $user;
                $cDateTime = $comment->created_at;
                $comment['datetime'] = $cDateTime->toDayDateTimeString();
                
            }
            $categories = Category::all();
            foreach ($categories as $cats) {
                $sec_id = $cats->section;
                $section_id = Section::where('id',$sec_id)->first();
                $section_name = $section_id->name;
                $cats['section_name'] = $section_name;
            }
            return view('discussion')->with('discussions', $discussions)->with('comments', $comments)->with('categories', $categories)->with('can_signature', $can_signature);
        } else {
            abort(404);
        }

    }

    /* show new discussion page */
    public function showNew($slug = null) {
        if (Auth::check()) {
            if ($slug == null) {
                if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
                    $categories = Category::all();
                } else {
                    $categories = Category::where('is_readonly',FALSE)->where('is_hidden',FALSE)->get();
                }
                foreach ($categories as $cat) {
                    $secID = $cat->section;
                    $section = Section::where('id',$secID)->get();
                    $cat['section'] = $section;
                }
                return view('newdiscussion', compact('categories'));
            } else {
                $count = DB::table('categories')->where('slug', $slug)->count();
                if ($count == 1) {
                    $count = DB::table('categories')->where(['slug' => $slug,'is_readonly' => FALSE])->count();
                    if ($count == 1) {
                        $category = Category::where('slug',$slug)->get();
                        foreach ($category as $cat) {
                            $secID = $cat->section;
                            $section = Section::where('id',$secID)->get();
                            $cat['section'] = $section;
                        }
                        return view('newdiscussion', compact('category'));
                    }
                    else {
                        if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
                            $category = Category::where('slug',$slug)->get();
                            foreach ($category as $cat) {
                                $secID = $cat->section;
                                $section = Section::where('id',$secID)->get();
                                $cat['section'] = $section;
                            }
                            return view('newdiscussion', compact('category'));
                        } else {
                            abort(403);
                        }
                    }
                } else {
                    abort(403);
                }
            }
        } else {
            abort(401);
        }
    }

    public function submit(NewDiscussionRequest $request)
    {
        $count = DB::table('discussions')->where('slug', $request->slug)->count();
        if ($count > 0) {
            abort(500);
        } else {
            $discussion = Discussion::create($request->validated());
            $slug = $discussion->slug;
            $member = $discussion->member;
            $id = $discussion->id;
            $timestamp = Carbon::now()->format('Y-m-d H:i:m');

            DB::table('watched')->insert([
                'member' => $member,
                'discussion' => $id,
                'created_at' => $timestamp,
                'type' => 'my',
            ]);
            
            $url = '/discussion/'.$slug;
            return redirect($url);

        }    

    }

    public function submitReply(NewCommentRequest $request)
    {
        $slug = $request->slug;
        $comment = Comment::create($request->validated());
        $timestamp = Carbon::now()->format('Y-m-d H:i:m');
        $updatetime = Discussion::where('slug', $slug)->update(['updated_at' => $timestamp]);
        $watched = DB::table('watched')->where('discussion', $comment->discussion)->get();
        foreach ($watched as $w) {
            $member = $w->member;
            if ($member != $comment->member) {
                NewReplyMail::dispatch($member,$comment->id);
            }
            
        }
        $url = '/discussion/'.$slug.'#lastreply';
        return redirect($url);

    }

    public function lock(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $lock = Discussion::where('slug', $slug)->update(['is_locked' => TRUE]);
        $url = '/discussion/'.$slug;
        return redirect($url);

    }

    public function unlock(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $lock = Discussion::where('slug', $slug)->update(['is_locked' => FALSE]);
        $url = '/discussion/'.$slug;
        return redirect($url);
    }

    public function hide(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $lock = Discussion::where('slug', $slug)->update(['is_hidden' => TRUE]);
        $url = '/discussion/'.$slug;
        return redirect($url);
    }

    public function unhide(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $lock = Discussion::where('slug', $slug)->update(['is_hidden' => FALSE]);
        $url = '/discussion/'.$slug;
        return redirect($url);
    }

    public function move(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $category = $request->category;
        $discussions = Discussion::where('slug',$slug)->get();
        foreach ($discussions as $discussion) {
           $discID = $discussion->id;
        }
        $updateDiscussion = Discussion::where('id', $discID)->update(['category' => $category]);
        $updateComments = Comment::where('discussion', $discID)->update(['category' => $category]);
        $url = '/discussion/'.$slug;
        return redirect($url);
    }

    public function delete(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $discussions = Discussion::where('slug',$slug)->get();
        foreach ($discussions as $discussion) {
           $discID = $discussion->id;
           $discCat = $discussion->category;
        }
        $deleteComments = Comment::where('discussion', $discID)->delete();
        $deleteDiscussion = Discussion::where('id', $discID)->delete();
        $category = Category::where('id',$discCat)->get();
        foreach ($category as $cat) {
            $catSlug = $cat->slug;
            $url = '/category/'.$catSlug;
            return redirect($url);
        }


    }

    public function edit(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $title = $request->title;
        $content = $request->content;
        $update = Discussion::where('slug', $slug)->update(['title' => $title, 'content' => $content]);
        $url = '/discussion/'.$slug;
        return redirect($url);
    }

    public function editComment(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $comment = $request->comment;
        $content = $request->content;
        $update = Comment::where('id', $comment)->update(['content' => $content]);
        $url = '/discussion/'.$slug.'#comment-'.$comment;
        return redirect($url);
    }

    public function deleteComment(ManageDiscussionRequest $request)
    {
        $slug = $request->slug;
        $comment = $request->comment;
        $delete = Comment::where('id', $comment)->delete();
        $url = '/discussion/'.$slug;
        return redirect($url);
    }

}
