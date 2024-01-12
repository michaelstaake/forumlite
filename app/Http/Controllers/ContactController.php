<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactFormRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Settings;
use App\Mail\NewContactEmail;


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

	public function sent() {
		return view('pages.contact')->with('success', 'Your message has been sent!');
	}

	public function submit(ContactFormRequest $request) {
		
		$contact_email = Settings::where('setting', 'contact_email')->first();
		$contact_email = $contact_email->value;

		$data = [
            'email' => $request->email,
            'content' => $request->content,
        ];

		Mail::to($contact_email)->send(new NewContactEmail($data));

		return redirect('/contact/sent');

		
	}
    
}
