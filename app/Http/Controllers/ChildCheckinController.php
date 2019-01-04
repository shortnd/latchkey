<?php

namespace App\Http\Controllers;

use App\Child;
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
        $am_checkin->update([ 'am_checkin' => $request->has(['am_checkin']), 'am_checkin_time' => Carbon::now()]);

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
