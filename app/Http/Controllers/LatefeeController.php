<?php

namespace App\Http\Controllers;

use App\Child;
use App\Checkin;
use Illuminate\Http\Request;

class LatefeeController extends Controller
{
    public function addLateFee(Child $child)
    {
        $lateFee = $child->todaysCheckin()->late_fee;

        $child->todaysCheckin()->update([
            'late_fee' => + 1
        ]);

        if ($child->todaysCheckin()->late_fee >= 1) {
            $child->dailyTotal()->update([
                'total_amount' => + 10
            ]);
        }

        return back();
    }
}
