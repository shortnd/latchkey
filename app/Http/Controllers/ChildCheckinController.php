<?php

namespace App\Http\Controllers;

use App\Child;
use App\Checkin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChildCheckinController extends Controller
{
    public function addNewCheckins(Child $child, Request $request)
    {
        $child->addCheckin($child);
        return back();
    }

    public function am_checkin(Child $child, Request $request)
    {
        $am_checkin = $child->todaysCheckin();
        $am_checkin->update([ 'am_checkin' => $request->has(['am_checkin'])]);
        return back();
    }

    public function pm_checkin(Child $child, Request $request)
    {
        $pm_checkin = $child->todaysCheckin();
        $pm_checkin->update(['pm_checkin' => $request->has(['pm_checkin'])]);
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
