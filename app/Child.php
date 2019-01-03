<?php

namespace App;

use Carbon\Carbon;
use App\Checkin;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $guarded = [];

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function todaysCheckin()
    {
        return $this->checkins()->whereDate('created_at', Carbon::today())->first();
    }

    public function pastWeeksCheckin()
    {
        $now = Carbon::now();
        $weekStart = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEnd = $now->endOfWeek()->format('Y-m-d H:i');

        return $this->checkins()->whereBetween('created_at', [$weekStart, $weekEnd])->get();
    }

    public function amCheckinTime()
    {
        return Carbon::parse($this->am_checkin_time)->format('h:i a');
    }

    public function addCheckin($child)
    {
        if ($this->todaysCheckin()) {
            return $errors['today_checkins'] = 'Already has checkin today.';
        } else {
            return $this->checkins()->create([
                'child_id' => $child->id
            ]);
        }
    }
}
