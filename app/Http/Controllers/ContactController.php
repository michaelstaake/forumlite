<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
	public function show() {
		// eventually here we will read a setting from control panel to see if we are redirecting to an external page or displaying the contact form.
		return view('contact');
	}
    
}
