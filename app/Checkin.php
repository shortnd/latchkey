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

    public function getCheckoutTime()
    {
        // return Carbon::createFromFormat('HH: MM', $this->pm_checkout_time)->toDateTimeString();
    }
}
