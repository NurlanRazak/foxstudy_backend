<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailToManager extends Mailable
{
    use Queueable, SerializesModels;

    protected $feedback;

    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = ['nurlan.adiluly@gmail.com'];

        return $this->to($cc)
                    ->subject("Отклик с email-a {$this->feedback->email} на Сайте foxstudy.kz")
                    ->markdown('mail.feedback')
                    ->with(['feedback' => $this->feedback]);
    }
}
