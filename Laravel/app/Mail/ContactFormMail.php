<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        // تأكد من تحويل البيانات إلى مصفوفة أو كائن
        $this->data = is_array($data) ? (object) $data : $data;
    }

    public function build()
    {
    
        return $this->subject('New Contact Form Message')
                    ->view('emails.contact')
                    ->with([
                        'name' => $this->data->name ?? '',
                        'email' => $this->data->email ?? '',
                        'message' => $this->data->message ?? '',
                    ]);
    }
    }

