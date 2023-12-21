<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function userSearch(Request $request)
    {
          $query = $request->get('query');
          $filterResult = User::where('username', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    } 
}
