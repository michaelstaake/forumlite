<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Discussion;
use App\Models\Section;
use App\Models\User;
use App\Models\Comment;

class CategoryController extends Controller
{
    public function show($c = null) {
    	$count = DB::table('categories')->where('slug', $c)->count();
    	if ($count == 1) {
    		$category = Category::where('slug', $c)->get();
    		foreach ($category as $cat) {
				$catID = $cat->id;
                $secID = $cat->section;
                $section = Section::where('id',$secID)->get();
                $cat['section'] = $section;
			}
            $results = Discussion::where('category', $catID)->orderBy('updated_at', 'desc')->get();
            foreach ($results as $result) {
                $userID = $result->member;
                $user = User::where('id',$userID)->get();
                $result['user'] = $user;
                $discID = $result->id;
                $numComments = DB::table('comments')->where('discussion', $discID)->count();
                $result['comments'] = $numComments;
                $rDateTime = $result->created_at;
                $result['datetime'] = $rDateTime->toDayDateTimeString();
                $rDateTime2 = $result->updated_at;
                $result['datetime2'] = $rDateTime2->toDayDateTimeString();
            }
			return view('category', compact('category'), compact('results'));
    	} else {
    		return redirect('/');
    	}

    }
}
