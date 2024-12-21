<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller   {
        // Show the contact page
        public function index()
        {
            return view('contact.index');
        }
    
        // Handle the contact form submission
        public function store(Request $request)
        {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'message' => 'required|string|min:10',
            ]);
            // Send the email using a mailable
            try {
                Mail::to('tutornet0@gmail.com')->send(new ContactFormMail($request));
    
                return redirect()->route('contact.index')->with('success', 'Your message has been sent successfully!');
            } catch (\Exception $e) {
                return redirect()->route('contact.home')->with('error', 'There was an issue sending your message.');
            }
        }
        
}
Mail::to('tutornet0@gmail.com')->send(new \App\Mail\ContactFormMail((object)[
    'name' => 'Test Name',
    'email' => 'hana.saif.1978@gmail.com',
    'message' => 'This is a test message.'
]));
