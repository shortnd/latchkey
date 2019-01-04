<?php

namespace App;

use App\CheckinTotals;
use App\Child;
use Illuminate\Database\Eloquent\Model;

class CheckinWeeklyTotals extends Model
{
    public function checkin_total()
    {
        return $this->belongsTo(CheckinTotals::class);
    }

    public function child()
    {
        return $this->belongToThrough(Child::class, CheckinTotals::class);
    }

}
