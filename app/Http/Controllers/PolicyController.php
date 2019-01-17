<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function __construct()
    {
        // Make this only accessible to admins
        return $this->middleware('auth')->except(['index']);
    }
    /**
     * Returns policy index page
     */
    public function index()
    {
        return view('policy.index');
    }

    public function edit()
    {
        // Added edit page for index;
    }
}
