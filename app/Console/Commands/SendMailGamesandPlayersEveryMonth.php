<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Form;
use Mail;
use App\Mail\GamersAndPlayers;
use Illuminate\Support\Facades\Log;

class SendMailGamesandPlayersEveryMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendMailGamesandPlayersEveryMonth:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "in every first month gamers and players previous month's data will send to admin";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $forms = Form::get();

            // dd($data);
            Mail::to('mangaletamang65@gmail.com')->send(new GamersAndPlayers($forms));
            Log::channel('spinnerBulk')->info("Custom mail sent successfully to " .' individual');
            // return redirect()->back()->withInput()->with('success', 'Mail Sent');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($e);
            Log::channel('spinnerBulk')->info($bug);
            // return redirect()->back()->withInput()->with('error', $bug);
        }
    }
}
