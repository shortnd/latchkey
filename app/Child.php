<?php

namespace App;

use Carbon\Carbon;
use App\Checkin;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $guarded = [];

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function todaysCheckin()
    {
        return $this->checkins()->whereDate('created_at', today())->first();
    }

    public function checkin_totals()
    {
        return $this->hasMany('App\CheckinTotals');
    }

    public function dailyTotal()
    {
        return $this->checkin_totals()->whereDate('created_at', today())->first();
    }

    public function weeklyTotals()
    {
        $now = Carbon::now();
        $startOfWeek = $now->startOfWeek()->format('Y-m-d H:i');
        $endOfWeek = $now->endOfWeek()->format('Y-m-d H:i');
        return $this->checkin_totals()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        // TODO ASK ABOUT calculations here... have alec look at it.
    }

    public function weeklyCheckins()
    {
        $now = Carbon::now();
        $monthStart = $now->startOfMonth()->format('Y-m-d H:i');
        $monthEnd = $now->endOfMonth()->format('Y-m-d H:i');

        return $this->checkins()->whereBetween('created_at', [$monthStart, $monthEnd])->orderBy('created_at', 'asc')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('W');
        });
    }

    public function pastWeeksCheckin()
    {
        $now = Carbon::now();
        $weekStart = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEnd = $now->endOfWeek()->format('Y-m-d H:i');

        return $this->checkins()->whereBetween('created_at', [$weekStart, $weekEnd])->orderBy('created_at', 'desc')->get();
    }

    public function addCheckin($child)
    {
        if ($this->todaysCheckin()) {
            return $errors['today_checkins'] = 'Already has checkin today.';
        } else {
            return $this->checkins()->create([
                'child_id' => $child->id,
            ]);
        }
    }

    public function addDailyTotal($child)
    {
        if ($this->dailyTotal()) {
            return $errors['daily_total'] = 'Daily total already created.';
        } else {
            return $this->checkin_totals()->create([
                'child_id' => $child->id,
            ]);
        }
    }

}
