<?php

namespace App;

use Carbon\Carbon;
use App\Child;
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
        $today = Checkin::where('user_id', $child->id)
                        ->whereDate('created_at', Carbon::today());

        return $today;
    }

    public function morningDisable()
    {
        $time = Carbon::now()->format('H');
        if ($time < 8) {
            return false;
        }
        return true;
    }

    public function afternoonDisable()
    {
        $time = Carbon::now()->format('H');
        if ($time > 15) {
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

    public function amCheckinTime()
    {
        return Carbon::parse($this->am_checkin_time)->format('h:i a');
    }
}
