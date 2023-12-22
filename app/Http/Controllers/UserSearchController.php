<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserSearchController extends Controller
{
    public function userSearch(Request $request)
    {
          $query = $request->get('to');
          $filterResult = User::where('username', 'LIKE', '%'. $query. '%')->get();
          return response()->json($filterResult);
    } 
}
