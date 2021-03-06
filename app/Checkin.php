<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $guarded = [];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function today($child)
    {
        $today = Checkin::where('user_id', $child->slug)
                        ->whereDate('created_at', today());

        return $today;
    }

    public function am_disabled()
    {
        // return false;
        $time = Carbon::now()->format('H.m');
        if ($time > 6.15 && $time < 7.45) {
            return false;
        }
        return true;
    }

    public function pm_disabled()
    {
        // return false;
        $time = Carbon::now()->format('H.m');
        if ($time > 15 && $time < 17.3) {
            return false;
        }
        return true;
    }

    public function pmCheckinTime()
    {
        return Carbon::parse($this->pm_checkin_time)->format('h:i a');
    }

    public function getCheckoutTime()
    {
        return Carbon::parse($this->pm_checkout_time)->format('h:i a');
    }

    public function getCheckoutDiffHumans()
    {
        return Carbon::parse($this->pm_checkout_time)->diffForHumans();
    }

    public function amCheckinTime()
    {
        return Carbon::parse($this->am_checkin_time)->format('h:i a');
    }
}
