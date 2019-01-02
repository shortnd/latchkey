<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Child;
use App\Checkin;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $children = Child::get();

        $children->each(function($item, $key) {
            $item['today_checkin'] = Checkin::whereDate('created_at', Carbon::today())->where('child_id', $item->id)->get();
        });
        return view('child.index')->withChildren($children);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('child.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $child = Child::create($this->validate($request, [
            'first_name' => 'required|max:225',
            'last_name' => 'required|max:225'
        ]));

        $child->addCheckin($child);

        return redirect('/children');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function show(Child $child)
    {
        $child['today'] = $child->checkins()->whereDate('created_at', Carbon::today())->get();

        return view('child.show')->withChild($child);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function edit(Child $child)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Child $child)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function destroy(Child $child)
    {
        $child->delete();

        return redirect('/children');
    }
}
