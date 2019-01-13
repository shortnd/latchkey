<?php

namespace App\Http\Controllers;

use App\Child;
use App\CheckinTotals;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChildCheckinController extends Controller
{
    public function addNewCheckins(Child $child, Request $request)
    {
        return $child->addCheckin($child);
    }

    /**
     * TODO: Refactor this
     */
    public function am_checkin(Child $child, Request $request)
    {
        $checkin = $child->todaysCheckin();
        $checkinTotals = $child->dailyTotal();

        $checkin->update([
            'am_checkin' => $request->has(['am_checkin']),
            'am_checkin_time' => Carbon::now()
        ]);
        $endTime = Carbon::create(today()->format('Y'), today()->format('m'), today()->format('d'), 8, 15, 0);
        // $endTime = Carbon::createFromTime(8, 15, 0);
        $todayAMTotalHours = $checkin->am_checkin_time->diff($endTime)->format('%H.%I');

        $checkinTotals->update([
            'total_hours' => $todayAMTotalHours,
            'am_total_hours' => $todayAMTotalHours,
            'total_amount' => 5
        ]);
        return back();
    }

    public function pm_checkin(Child $child, Request $request)
    {
        $pm_checkin = $child->todaysCheckin();
        // $time = Carbon::createFromTime(15, 0, 0);
        $time = Carbon::create(today()->format('Y'),today()->format('m'),today()->format('d'),15,0,0);
        $pm_checkin->update(['pm_checkin' => $request->has(['pm_checkin']), 'pm_checkin_time' => $time]);
        return back();
    }

    public function pm_checkout(Child $child, Request $request)
    {
        $pm_checkout = $child->todaysCheckin();
        $checkinTotals = $child->dailyTotal();

        if ($request->has('pm_checkout')) {
            $pm_checkout->update(['pm_checkout_time' => Carbon::now()]);

            $pm_diff = Carbon::parse($pm_checkout->pm_checkin_time)->diff($pm_checkout->pm_checkout_time)->format('%H.%I');
            $rollingTotalHours = $checkinTotals->total_hours + $pm_diff;

            $pm_amount = $pm_diff * 4;
            $rollingTotalAmount = $checkinTotals->total_amount + $pm_amount;

            $checkinTotals->update([
                'total_hours' => $rollingTotalHours,
                'total_amount' => $rollingTotalAmount
            ]);

        } else {
            return $errors['pm_checkout'] = 'Invalid Input';
        }
        return back();
    }
}
