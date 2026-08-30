<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Jobs\SendEmailJob;

class ShippedController extends Controller
{
    public function send() {

        // $Pmail0 = "sirov@ukr.net";


        // Mail::send('emails.deffault', array('Pmail' => $Pmail0), function($message)
        //     // Mail::queue('emails.deffault', array('Pmail' => $Pmail0), function($message)
        // {
        //     $Pmail = "sirov@ukr.net";
        //     $subj = "Хтось залишив запитання на форумі міста Носівка";
        //     $id = 832;
        //     $unsub = "<$Pmail>, <https://1ua.com.ua/unsubscribe/$Pmail/$id>";
        //     $message->getHeaders()->addTextHeader("List-Unsubscribe",$unsub);
        //    // $message->getHeaders()->addTextHeader('MIME-Version', '1.0'); $message->getHeaders()->addTextHeader('Content-Type', 'text/html');
        //     $message->subject($subj)->to($Pmail);
        // });
        dispatch(new SendEmailJob([
            'email' => 'v74799782@gmail.com',
            'subject' => 'test',
            'blade' => 'emails.deffault',
               'det' => [
                'email' => 'v74799782@gmail.com',
            ],
            'unsub' => '',
        ]));
    }
}

