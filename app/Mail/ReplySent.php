<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplySent extends Mailable
{
    use Queueable, SerializesModels;

    public $msg; // CAUTION: Conflict between the Model Message $message and the Laravel Mail Message objects
	public $replyForm;

    /**
     * Create a new message instance.
     *
	 * @param Message $msg
	 * @param $replyForm
	 */
    public function __construct(Message $msg, $replyForm)
    {
        $this->msg = $msg;
		$this->replyForm = $replyForm;

        $this->to($msg->email, $msg->name);
        $this->replyTo($replyForm->sender_email, $replyForm->sender_name);
        $this->subject(trans('mail.reply_form_title', [
            'postTitle' => $replyForm->post_title,
            'appName'   => config('app.name')
        ]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.post.reply-sent');
    }
}
