<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use App\Http\Requests\SearchRequest;
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

    public function showResults(SearchRequest $request) {

    	$discussions = Discussion::search($request->query)->get();
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
		$comments = Comment::search($request->query)->get();
		foreach ($comments as $comment) {
			$comment['type'] = 'comment';
			$commID = $comment->id;
			$discID = $comment->discussion;
			$userID = $comment->member;
			$discussion = Discussion::where('id',$discID)->get();
			foreach ($discussion as $disc) {
				$comment['slug'] = $disc->slug;
				$comment['title'] = $disc->title;
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

		//return $results;
		return view('search.results')->with('results', $results);
    }
}
