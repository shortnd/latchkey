<?php

namespace App;

use App\Child;
use Illuminate\Database\Eloquent\Model;

class CheckinTotals extends Model
{
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function weekly_totals()
    {
        return $this->hasMany('weekly_totals');
    }
}
