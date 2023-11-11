<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\RefferNotice;
class ReferDetailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mailData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            Mail::to("mangaletamang65@gmail.com")->send(new RefferNotice(json_encode($this->mailData)));
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            Log::channel('spinnerBulk')->info($bug);
            // return redirect()->back()->withInput()->with('error', $bug);
        }


    }
}
