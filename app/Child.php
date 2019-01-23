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

    public function todayTotal()
    {
        $total = 0;
        $today = $this->todaysCheckin();
        if ($today->am_checkin) {
            $total += 5;
        }
        if ($today->pm_checkout_time) {
            $pm_diff = Carbon::parse($today->pm_checkout_time)->diff(Carbon::parse($today->pm_checkin_time))->format('%H.%I');
            $total += $pm_diff * 4;
        }
        return round($total);
    }

    public function checkin_totals()
    {
        return $this->hasMany('App\CheckinTotals');
    }

    // public function dailyTotal()
    // {
    //     return $this->checkin_totals()->whereDate('created_at', today())->first();
    // }

    /**
     * Need to refactor this / rename
     */
    public function weekly_Total()
    {
        $now = Carbon::now();
        $startOfWeek = $now->startOfWeek()->format('Y-m-d H:i');
        $endOfWeek = $now->endOfWeek()->format('Y-m-d H:i');

        return $this->checkin_totals()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->first();
    }

    protected function weeklyTotals()
    {
        $now = Carbon::now();
        $startOfWeek = $now->startOfWeek()->format('Y-m-d H:i');
        $endOfWeek = $now->endOfWeek()->format('Y-m-d H:i');
        return $this->checkin_totals()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
    }

    public function weeklyAmCheckinTotals()
    {
        return $this->weeklyTotals()->sum('am_total_hours');
    }

    public function weeklyCheckinTotals()
    {
        return $this->weeklyTotals()->sum('total_hours');
    }

    public function weeklyTotal()
    {
        return $this->weeklyTotals()->sum('total_amount');
    }

    public function todayCheckin()
    {
        return $this->checkins()->whereDate('created_at', today())->first();
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
        if ($this->weekly_Total()) {
            return $errors['weekly_total'] = 'Weekly total already created';
        } else {
            return $this->checkin_totals()->create([
                'child_id' => $child->id
            ]);
        }
        // if ($this->dailyTotal()) {
        //     return $errors['daily_total'] = 'Daily total already created.';
        // } else {
        //     return $this->checkin_totals()->create([
        //         'child_id' => $child->id,
        //     ]);
        // }
    }
}
