<?php

namespace App\Http\Controllers;

use App\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChildSearchController extends Controller
{
    public function index(Child $child)
    {
        return view('child.search.index', ['child' => $child]);
    }
    public function show(Child $child, Request $request)
    {
        $checkins = $child->checkins()->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        $checkins = $checkins->groupBy(function($checkin) {
            return Carbon::parse($checkin->created_at)->format('m');
        });
        return view('child.search.show', ['checkins' => $checkins]);
    }
}
