<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendGrid extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
	$this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	$from_address = env('MAIL_FROM_ADDRESS');
	$from_name = env('MAIL_FROM_NAME');
	$subject = $this->data['subject'];

        return $this->markdown('emails.sendGrid')
			->from($from_address, $from_name)
			->replyTo($from_address, $from_name)
			->subject($subject)
			->with([ 'message'=> $this->data['message'] ]);
    }
}
