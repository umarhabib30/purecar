<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StripeRenewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $advertName;
    public $expiryDate;
    public $totalPayment;
    public $packageName;

    
    public function __construct($advertName, $expiryDate, $totalPayment, $packageName)
    {
        $this->advertName = $advertName;
        $this->expiryDate = $expiryDate;
        $this->totalPayment = $totalPayment;
        $this->packageName = $packageName;
    }

    
    public function build()
    {
        return $this->subject('Your advert has been renewed')
                    ->view('emails.stripe_renew')
                    ->with([
                        'advertName' => $this->advertName,
                        'expiryDate' => $this->expiryDate,
                        'totalPayment' => $this->totalPayment,
                        'packageName' => $this->packageName,
                    ]);
    }
}
