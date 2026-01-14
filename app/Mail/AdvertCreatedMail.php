<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdvertCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $advert;
    public $car;
    public $carUrl; 

    
    public function __construct($advert, $car)
    {
        $this->advert = $advert;
        $this->car = $car;
        $this->carUrl = url('car-for-sale/' . $car->slug); 
    }

   
    public function build()
    {
        return $this->subject('Your advert is now live')
                    ->view('emails.advert_created')
                    ->with([
                        'advert' => $this->advert,
                        'car' => $this->car,
                        'carUrl' => $this->carUrl, 
                    ]);
    }
}
