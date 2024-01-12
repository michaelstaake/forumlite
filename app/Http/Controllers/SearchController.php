<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Section;
use App\Models\User;

class SearchController extends Controller
{
    public function showForm()
    {
        return view('search.search');
    }

	public function searchUserDiscussions($user = null) {
		$count = DB::table('users')->where('username', $user)->count();
		if ($count == 1) {
			$query = $user;
			$member = User::where('username', $user)->first();
			$member_id = $member->id;
			if (Auth::check()) {
				if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
                    $discussions = Discussion::where('member', $member_id)->get();
                } else {
                    $discussions = Discussion::where('member', $member_id)->where('is_hidden', FALSE)->get();
                }
			} else {
				$discussions = Discussion::where('member', $member_id)->where('is_hidden', FALSE)->get();
			}
			foreach ($discussions as $discussion) {
				$discussion['type'] = 'discussion';
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
				$discussion['content_summary'] = Str::limit($discussion->content, 200);
			}
			$results = $discussions->sortByDesc('created_at')->paginate(10);
			return view('search.results')->with('results', $results)->with('type','searchUserDiscussions')->with('query', $query);

		} else {
			return redirect('/search');
		}
	}

	public function searchUserComments($user = null) {
		$count = DB::table('users')->where('username', $user)->count();
		if ($count == 1) {
			$query = $user;
			$member = User::where('username', $user)->first();
			$member_id = $member->id;
			if (Auth::check()) {
				if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
                    $comments = Comment::where('member', $member_id)->get();
                } else {
                    $comments = Comment::where('member', $member_id)->where('is_hidden', FALSE)->get();
                }
			} else {
				$comments = Comment::where('member', $member_id)->where('is_hidden', FALSE)->get();
			}
			foreach ($comments as $comment) {
				$comment['type'] = 'comment';
				$commID = $comment->id;
				$discID = $comment->discussion;
				$userID = $comment->member;
				$discussion = Discussion::where('id',$discID)->get();
				foreach ($discussion as $disc) {
					$comment['slug'] = $disc->slug;
					$comment['title'] = $disc->title;
					if ($disc->is_hidden == TRUE) {
						$comment['is_hidden'] = TRUE;
					}
				}
				$user = User::where('id',$userID)->get();
				$comment['user'] = $user;
				$catID = $comment->category;
				$category = Category::where('id',$catID)->get();
				$comment['category'] = $category;
				foreach ($category as $cat) {
					$secID = $cat->section;
					$section = Section::where('id',$secID)->get();
					$comment['section'] = $section;
				}
				$cDateTime = $comment->created_at;
				$comment['datetime'] = $cDateTime->toDayDateTimeString();
				$comment['content_summary'] = Str::limit($comment->content, 200);
			}
			$results = $comments->where('is_hidden', FALSE)->sortByDesc('created_at')->paginate(10);
			return view('search.results')->with('results', $results)->with('type','searchUserComments')->with('query', $query);

		} else {
			return redirect('/search');
		}
	}

	public function searchNewPosts() {
		$user = auth()->user()->username;
		$count = DB::table('users')->where('username', $user)->count();
		if ($count == 1) {
			return view('search.results')->with('results', $results)->with('type','searchNewPosts')->with('query', $query);
		} else {
			return redirect('/search');
		}
	}

    public function searchResults(SearchRequest $request) {

		$query = $request->input('query');
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$discussions = Discussion::search($query)->get();
			} else {
				$discussions = Discussion::search($query)->where('is_hidden', FALSE)->get();
			}
		} else {
			$discussions = Discussion::search($query)->where('is_hidden', FALSE)->get();
		}
		foreach ($discussions as $discussion) {
			$discussion['type'] = 'discussion';
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
			$discussion['content_summary'] = Str::limit($discussion->content, 200);
		}
		$comments = Comment::search($query)->get();
		foreach ($comments as $comment) {
			$comment['type'] = 'comment';
			$commID = $comment->id;
			$discID = $comment->discussion;
			$userID = $comment->member;
			$discussion = Discussion::where('id',$discID)->get();
			foreach ($discussion as $disc) {
				$comment['slug'] = $disc->slug;
				$comment['title'] = $disc->title;
				if ($disc->is_hidden == TRUE) {
					$comment['is_hidden'] = TRUE;
				} else {
					$comment['is_hidden'] = FALSE;
				}
			}
			$user = User::where('id',$userID)->get();
			$comment['user'] = $user;
			$catID = $comment->category;
			$category = Category::where('id',$catID)->get();
			$comment['category'] = $category;
			foreach ($category as $cat) {
				$secID = $cat->section;
				$section = Section::where('id',$secID)->get();
				$comment['section'] = $section;
			}
			$cDateTime = $comment->created_at;
			$comment['datetime'] = $cDateTime->toDayDateTimeString();
			$comment['content_summary'] = Str::limit($comment->content, 200);
		}
		$results = collect();
		$results = $results->merge($discussions)->merge($comments);
		if (Auth::check()) {
			if (auth()->user()->group === "admin" || auth()->user()->group === "mod") {
				$results = $results->sortByDesc('created_at')->paginate(10);
			} else {
				$results = $results->where('is_hidden', FALSE)->sortByDesc('created_at')->paginate(10);
			}
		} else {
			$results = $results->where('is_hidden', FALSE)->sortByDesc('created_at')->paginate(10);
		}

		return view('search.results')->with('results', $results)->with('type','searchResults')->with('query', $query);
    }
}
