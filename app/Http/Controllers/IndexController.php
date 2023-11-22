<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Discussion;
use App\Models\Comment;

class IndexController extends Controller
{
    public function show() {
    	$sections = Section::all();
    	$categories = Category::all();
    	foreach ($categories as $category) {
	        $categoryID = $category->id;
	        $numDiscussions = DB::table('discussions')->where('category', $categoryID)->count();
            $category['numDiscussions'] = $numDiscussions;
	        $numComments = DB::table('comments')->where('category', $categoryID)->count();
            $category['numComments'] = $numComments;
	    }
    	return view('index', compact('sections'), compact('categories'));
    }
}
