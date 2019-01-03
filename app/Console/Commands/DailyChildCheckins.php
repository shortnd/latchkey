<?php

namespace App\Console\Commands;

use App\Child;
use Illuminate\Console\Command;

class DailyChildCheckins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'children:dailytable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new daily entry for every child in the database';

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
     * @return mixed
     */
    public function handle()
    {
        Child::get()->each(function ($child) {
            $child->addCheckin($child);
        });
    }
}
