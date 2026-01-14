<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Advert;
use App\Mail\AdvertExpiredMail;
use Illuminate\Support\Facades\Mail;

class SendAdvertExpiryEmails extends Command
{
    
    protected $signature = 'emails:send-expiry';

    
    protected $description = 'Send emails to users for expired adverts';

    
    public function handle()
    {
       
        $expiredAdverts = Advert::where('expiry_date', '<', now())
            ->where('email_sent', false) 
            ->get();

        foreach ($expiredAdverts as $advert) {
      
            Mail::to($advert->user->email)->send(new AdvertExpiredMail(
                $advert->user->name,
                $advert->name,
                $advert->expiry_date
            ));

        
            $advert->update([
                'status'=>'inactive',
                'email_sent' => true
        
        ]);

            $this->info("Email sent for advert ID {$advert->id}.");
        }

        $this->info('All expiry emails processed successfully.');
    }
}
