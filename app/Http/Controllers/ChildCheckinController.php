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

    public function am_checkin(Child $child, Request $request)
    {
        $am_checkin = $child->todaysCheckin();
        $dailyTotals = $child->dailyTotal();
        $today_totals;


        $am_checkin->update([ 'am_checkin' => $request->has(['am_checkin']), 'am_checkin_time' => Carbon::now()]);

        $endTime = Carbon::create(today()->format('Y'), today()->format('m'), today()->format('d'), 8, 15, 0);
        $today_totals = $am_checkin->am_checkin_time->diff($endTime)->format('%H.%I');
        $currentTotal = $dailyTotals->total_hours + $today_totals;
        $amTotal = $today_totals;


        $dailyTotals->update([
            'total_hours' => $currentTotal,
            'am_total_hours' => $amTotal,
        ]);

        return back();
    }

    public function pm_checkin(Child $child, Request $request)
    {
        $pm_checkin = $child->todaysCheckin();
        $time = Carbon::createFromTime(15, 0, 0);
        $pm_checkin->update(['pm_checkin' => $request->has(['pm_checkin']), 'pm_checkin_time' => $time]);
        return back();
    }

    public function pm_checkout(Child $child, Request $request)
    {
        $pm_checkout = $child->todaysCheckin();

        if ($request->has('pm_checkout')) {
            $pm_checkout->update(['pm_checkout_time' => Carbon::now()]);
        } else {
            return $errors['pm_checkout'] = 'Invalid Input';
        }
        return back();
    }
}
