<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Log;

class InactiveBulkMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details) {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = GeneralSetting::first();
        $data = json_decode($this->details,true);
        $details = [
            'days' => $data['days'],
            'message' => $data['message'],
            'name' => $data['name'],
            'form_id' => ($data['form_id']),
            'theme' => ($settings->theme)
        ];
        $subject = isset($data['subject'])?$data['subject']:'Noor Games';

        $title = ($settings->theme == 'default')?'Noor':ucwords($settings->theme);

        return $this->from('noorgames@gmail.com', $title.' Games')
                    ->subject($subject)
                    ->markdown('mails.inactivePlayer')
                    ->with([
                        'details1' => (!empty($details) ? $details : '') 
                           ]);
    }
}
