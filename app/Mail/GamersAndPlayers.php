<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Form;

class GamersAndPlayers extends Mailable
{
    public $data;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = Form::get();
        $subject = "Forms Details";
        return $this->from('mangal12@sharewarenepal.com', 'Noor Games')
                    ->subject($subject)
                    ->markdown('mails.playersandgamers')
                    ->with([
                        'details' => (!empty($details) ? $details : '') 
                           ]);
        // return $this->view('view.name');
    }
}
