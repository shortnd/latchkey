<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Child;

class AddLateFee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'children-latefee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds late fee for children who are checkin after a certian time';

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
        $children = Child::with(['checkins' => function ($query) {
                $query->whereDate('created_at', today());
        }])->with(['checkin_totals' => function ($query) {
                $query->whereBetween('created_at', [startOfWeek(), endOfWeek()]);
        }])->get();

        $children->map(function ($child) {
            if ($child->checkins->first()->pm_checkin_time !== null && $child->checkins->first()->pm_checkout_time === null) {
                $late_fee = $child->checkins->first()->late_fee + 1;
                $total_amount = $child->checkin_totals->first()->total_amount + 10;
                $child->todaysCheckin()->update([
                    'late_fee' => $late_fee
                ]);
                $child->weeklyTotals()->update([
                    'total_amount' => $total_amount
                ]);
            }
        });

        $this->comment('Late Fees Added');
    }
}
