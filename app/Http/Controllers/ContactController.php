<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use App\Models\Settings;

class ContactController extends Controller
{
	public function show() {
		$contact_type = Settings::where('setting', 'contact_type')->first();
		$contact_type = $contact_type->value;
		if ($contact_type === "custom") {
			$contact_link = Settings::where('setting', 'contact_link')->first();
			$contact_link = $contact_link->value;
			return redirect()->away($contact_link);
		} else {
			return view('pages.contact');
		}
		
	}

	public function submit(ContactFormRequest $request) {
		$email = $request->email;
		$content = $request->content;
		

		
	}
    
}
