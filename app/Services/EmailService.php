<?php

namespace App\Services;
use Illuminate\Support\Facades\Mail;


class EmailService
{

    public function welcomeEmail($email)
    {
        Mail::send('emails/welcome', [],  function ($message) use ($email)
        {
            $message->from('retocima@gmail.com', 'Reto Cima');
            $message->to($email);
        });
    }

    public function resetPasswordRequestEmail($email,$link)
    {

        Mail::send('emails/reset-password-request', ['link' => $link], function ($message) use ($email)
        {
            $message->from('retocima@gmail.com', 'Reto Cima');
            $message->to($email);
        });
    }

    public function resetPasswordSuccessEmail($email)
    {

        Mail::send('emails/reset-password-success', [],  function ($message) use ($email)
        {
            $message->from('retocima@gmail.com', 'Reto Cima');
            $message->to($email);
        });
    }

}


