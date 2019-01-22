<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = ['policy'];
    protected $guarded = ['id'];
}
