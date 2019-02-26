<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Removing this because its now wrapped in web.php routes file
    // public function __construct()
    // {
    //     $this->middleware('role:superuser|admin');
    // }

    /**
     * Returns all users except for current logged in user
     *
     * @return void
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('users.index')->withUsers($users);
    }

    public function edit(User $user)
    {
        return view('users.edit')->withUser($user);
    }

    public function updatedName(Request $request, User $user)
    {
        // dd($request->name);
        // $this->validate($request, [
        //     'name' => 'required|min:2|max:255'
        // ]);
        dd($user->update($this->validate($request, [
            'name' => 'required|min:2|max:255'
        ])));

        return redirect()->back();
    }
}
