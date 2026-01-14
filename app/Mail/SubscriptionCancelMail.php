<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionCancelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $advertName;
    public $cancellationDate;

   
    public function __construct($advertName, $cancellationDate)
    {
        $this->advertName = $advertName;
        $this->cancellationDate = $cancellationDate;
    }

    
    public function build()
    {
        return $this->subject('Subscription Cancelled')
                    ->view('emails.subscription_cancel')
                    ->with([
                        'advertName' => $this->advertName,
                        'cancellationDate' => $this->cancellationDate,
                    ]);
    }
}
