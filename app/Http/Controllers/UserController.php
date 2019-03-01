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
        // TODO: add a policy or find another way to check here
        if($user->slug == auth()->user()->slug or auth()->user()->hasRole('superuser')) {
            return view('users.edit')->withUser($user);
        }
        return abort(403);
    }

    public function updatedName(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:255'
        ]);

        $user->update(['name' => $request->name]);

        return redirect()->back();
    }

    public function updateEmail(Request $request, User $user)
    {
        $this->validate($request, [
            'current_email' => 'required|email',
            'email' => 'required|email|unique:users|confirmed',
        ]);

        if($user->email === $request->current_email) {
            $user->update(['email' => $request->email]);
            return redirect()->back();
        } else {
            $errors = array('email' => 'Email did not match our records. Please try again');
            return redirect()->back()->withErrors($errors);
        }
    }
}
