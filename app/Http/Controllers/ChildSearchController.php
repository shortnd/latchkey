<?php

namespace App\Http\Controllers;

use App\Child;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildSearchController extends Controller
{
    public function index(Child $child)
    {
        return view('child.search.index', ['child' => $child]);
    }
    public function show(Child $child, Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required|before:today',
            'end_date' => 'required'
        ]);

        $checkins = $child->checkins()->whereBetween('created_at', [$request->start_date, $request->end_date])->orderBy('created_at', 'desc')->get();

        $checkins = $checkins->groupBy(function($checkin) {
            return Carbon::parse($checkin->created_at)->format('W');
        });

        return view('child.search.show', ['checkins' => $checkins]);
    }
}
