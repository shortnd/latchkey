<?php

namespace App\Http\Controllers;

use App\Child;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
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
        $children = Child::orderBy('last_name')->get();

        $children->map(function ($child) {
            $child->today_checkin = $child->checkins()->where('child_id', $child->id)->whereDate('created_at', today())->first();
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
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $child = new Child;
        $child->first_name = $request->first_name;
        $child->last_name = $request->last_name;

        $child->slug = SlugService::createSlug(Child::class, 'slug', $child->fullName());
        $child->save();

        $child->addCheckin();
        $child->addWeeklyTotal();

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
        $child->today = $child->checkins()->first();
        $child->totals = $child->weeklyTotal();

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
        if (auth()->user()->isA('superuser') || auth()->user()->isAn('admin')) {
            return view('child.edit')->withChild($child);
        }
        return back()->withErrors('Unauthorized');
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
        $child->update($this->validate($request, [
            'first_name' => 'required|max:225',
            'last_name' => 'required|max:225'
        ]));

        return back();
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

    public function weekly_totals()
    {
        $children = Child::paginate(10);
        $children->map(function ($child) {
            return $child->weekly_total = $child->weeklyTotal();
        });

        return view('child.weekly_totals')->withChildren($children);
    }

    public function all_checkins(Child $child)
    {
        $child->months = $child->checkins->groupBy(function ($month) {
            return Carbon::parse($month->created_at)->format('m');
        });

        return view('child.all_checkins')->withCheckins($child);
    }
}
