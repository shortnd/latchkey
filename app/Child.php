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

    public function addCheckin($child)
    {
        if (!$this->checkins()->first() == Carbon::now()->toDateString()) {
            return $this->checkins()->create([
                'child_id' => $child->id
            ]);
        }
    }
}
