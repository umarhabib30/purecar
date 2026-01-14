<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StripeAutoRenewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $advertTitle;
    public $expiryDate;
    public $amount;
    public $packageName;

    public function __construct($advertTitle, $expiryDate, $amount, $packageName)
    {
        $this->advertTitle = $advertTitle;
        $this->expiryDate = $expiryDate;
        $this->amount = $amount;
        $this->packageName = $packageName;
    }

    public function build()
    {
        return $this->view('emails.stripe_auto_renew')
                    ->subject('Advert Autorenewal Confirmation');
    }
}