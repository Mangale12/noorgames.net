<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NewHomeController;
class ReferDetailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'referdetails:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $newHomecontroller = new NewHomeController();
        $newHomecontroller->referCron();
        dd("done");
    }
}
