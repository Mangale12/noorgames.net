<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Form;
use Carbon\Carbon;

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
        $today = Carbon::now();
        $yesterday = $today->subDay();
        $firstDate = $today->subDay()->toDateString();
        $secondDate = $yesterday->subMonth()->toDateString();
        $details = Form::whereBetween('created_at',[$secondDate,$firstDate])->get();
        // $details = Form::get();
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
