<?php

namespace App;

use App\Child;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CheckinTotals extends Model
{
    protected $guarded = [];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
