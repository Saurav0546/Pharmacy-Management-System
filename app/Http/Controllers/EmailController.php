<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PharmacyEmail;

class EmailController extends Controller
{
    public function sendPharmacyEmail() {
        $toEmail =  'forest2931@gmail.com';
        $message = 'Welcome to pharmacy';
        $subject = 'Welcome to Pharmacy Management System';
        
        $response = Mail::to($toEmail)->send(new PharmacyEmail($message, $subject));
        
        dd($response);

    }
}