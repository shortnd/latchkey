<?php

namespace App;

use Carbon\Carbon;
use App\Checkin;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // static::create(function () {

        // });
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function addCheckin($child)
    {
        if (!$this->checkins()->whereDate('created_at', Carbon::today())->get()) {
            return $errors['today_checkins'] = 'Already has checkin today.';
        } else {
            return $this->checkins()->create([
                'child_id' => $child->id
            ]);
        }
    }
}
