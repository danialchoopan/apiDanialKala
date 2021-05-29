<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailValidateUser extends Mailable
{
    use Queueable, SerializesModels;
 
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()

    {
        return $this->
        from('danialkala@danialchoopan.ir')->
        subject('تایید حساب کاربری دانیال کالا')->view('emails.validate',['details'=>$this->details]);
    }
}
