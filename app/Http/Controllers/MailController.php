<?php

namespace App\Http\Controllers;

use App\Mail\ExampleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function check()
    {
        return view('emails.example');
    }

    public function sendEmail()
    {
        $data = [
            'name' => 'Lerian Febriana',
        ];
        Mail::to('kanglerian.lp3i@gmail.com')->send(new ExampleMail($data));
        echo 'Terkirim!';
        return;
    }
}
