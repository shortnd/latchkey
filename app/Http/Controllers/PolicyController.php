<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function __construct()
    {
        // Make this only accessible to admins
        // return $this->middleware('auth')->except(['index']);
    }
    /**
     * Returns policy index page
     */
    public function index()
    {
        return view('policy.index')->withPolicy(Policy::first());
    }

    public function edit()
    {
        // Added edit page for index;
        return view('policy.edit')->withPage(Policy::first());
    }

    public function update(Request $request)
    {
        $policy = Policy::first();
        $policy->update([
            'policy' => $request->policy
        ]);
    }
}
