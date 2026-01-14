<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StripeAdvertPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $packageName;
    public $packagePrice;
    public $expiryDate;

   
    public function __construct($userName, $packageName, $packagePrice, $expiryDate)
    {
        $this->userName = $userName;
        $this->packageName = $packageName;
        $this->packagePrice = $packagePrice;
        $this->expiryDate = $expiryDate;
    }

   
    public function build()
    {
        return $this->subject('Thank you for your payment')
                    ->view('emails.stripe_advert_published')
                    ->with([
                        'userName' => $this->userName,
                        'packageName' => $this->packageName,
                        'packagePrice' => $this->packagePrice,
                        'expiryDate' => $this->expiryDate,
                    ]);
    }
}
