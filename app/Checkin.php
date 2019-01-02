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

    public function today()
    {
        // dd(Carbon::today());
        dd($this->created_at == Carbon::today());
        dd($this::whereDate('created_at', Carbon::today()));
        return $this->where('created_at', Carbon::now()->toTimeString());
    }
}
