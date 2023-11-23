<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;
use App\Http\Requests\SearchRequest;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\User;

class SearchController extends Controller
{
    public function showForm()
    {
        return view('search.search');
    }

    public function showResults(SearchRequest $request) {

    	$query = $request->query;
    	$type = $request->type;
    	if ($type === "discussions_only") {
			$discussions = Discussion::search($query)->raw();
			$results = $discussions;
    	} else {
    		$discussions = Discussion::search($query)->raw();
    		$comments = Comment::search($query)->raw();
    		$results = array_merge($discussions,$comments);
    	}
    	return $results;
    	//return view('search.results', compact('results'));
    }
}
