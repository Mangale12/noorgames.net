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
    public function __construct($forms)
    {
        $this->data = $forms;
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
        $load_balance = json_decode($this->data,true);// $details = Form::get();
        $subject = "Forms Details";
        return $this->from('mangal12@sharewarenepal.com', 'Noor Games')
                    ->subject($subject)
                    ->markdown('mails.playersandgamers')
                    ->with(['load_balance'=>$load_balance]);
        // return $this->view('view.name');
    }
}
