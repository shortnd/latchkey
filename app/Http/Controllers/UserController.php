<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superuser|admin');
    }

    /**
     * Returns all users except for current logged in user
     *
     * @return void
     */
    public function index()
    {
        return User::whereNot('user_id', Auth::user()->id)->get();
    }
}
