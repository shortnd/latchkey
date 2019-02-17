<?php

namespace App\Http\Controllers;

use App\Child;
use Illuminate\Http\Request;

class ChildSearchController extends Controller
{
    public function index(Child $child)
    {
        return view('child.search.index', ['child' => $child]);
    }
    public function show(Child $child, Request $request)
    {
        return $child->checkins()->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        // dd($request);
    }
}
