<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Manager;

class NewSubscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cc = Manager::all()->pluck('email');

        return $this->to('nurlan.bboy@gmail.com')
                    ->cc($cc)
                    ->subject("Запись на курс с email-a {$this->subscription->email} на сайте Foxstudy.kz")
                    ->markdown('mail.subscription')
                    ->with(['subscription' => $this->subscription]);
    }
}
