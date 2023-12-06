<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function showTermsRules() 
    {
        $content = DB::table('pages')->where('page', 'terms')->get();
        return view('pages.terms-rules', compact('content'));
    }

    public function showPrivacyPolicy() 
    {
        $content = DB::table('pages')->where('page', 'privacy')->get();
        return view('pages.privacy-policy', compact('content'));
    }
}
