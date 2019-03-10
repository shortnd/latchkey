<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckinTotals extends Model
{
    protected $guarded = [];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    // public function pastDue($child)
    // {
    //     $this->where('created_at')
    //     // return
    // }
}
