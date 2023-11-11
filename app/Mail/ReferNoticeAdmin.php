<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\GeneralSetting;

class ReferNoticeAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
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
        $settings = GeneralSetting::first();
        // $details = $this->details;
        $subject = 'Reffer Amount Loaded';
        $details1 = [
            'text' => $this->data,
            'theme' => ($settings->theme),
        ];


        $title = ($settings->theme == 'default')?'Noor':ucwords($settings->theme);

        return $this->from('filesend@handy777.net', "reffer test".' Games')
                    ->subject($subject)
                    ->markdown('mails.reffernoticeadmin')
                    ->with([
                        'details' => (!empty($details1) ? $details1 : '')
                           ]);

    }
}
