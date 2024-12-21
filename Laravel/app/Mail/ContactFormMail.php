<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class ContactFormMail extends Mailable
{
    public $name;
    public $email;
    public $message;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(Request $request)
    {
        // Pass the validated data to the mailable
        $this->name = $request->name;
        $this->email = $request->email;
        $this->message = $request->message;
    }
    
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Contact Message')
                    ->view('emails.contact')
                    ->with([
                        'name' => $this->name,
                        'email' => $this->email,
                        'message' => $this->message,
                    ]);
    }
}
