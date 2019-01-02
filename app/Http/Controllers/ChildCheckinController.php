<?php

namespace App\Http\Controllers;

use App\Child;
use App\Checkin;
use Illuminate\Http\Request;

class ChildCheckinController extends Controller
{
    public function addNewCheckins(Child $child, Request $request)
    {
        $child->addCheckin($child);
        return back();
    }
}
