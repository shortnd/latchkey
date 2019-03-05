<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
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

    public function updatePassword(Request $request, User $user)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6|max:60'
        ]);

        if (Hash::check($request->current_password, $user->password)) {
            $user->update(['password' => Hash::make($request->password)]);
            return redirect()->back();
        } else {
            $errors = array('current_password' => "Password did not match our records. Please try again later.");
            return redirect()->back()->withErrors($errors);
        }
    }

    public function addRoleToUser(Request $request, User $user)
    {
        if (Auth::user()->hasRole('superuser') || Auth::user()->slug != $user->slug) {
            $inputs = $request->only(['admin']);
            foreach ($inputs as $key => $value) {
                if ($user->hasRole($key)) {
                    $user->removeRole($key);
                } else {
                    $role = Role::create(['name' => $key]);
                    $user->assignRole($role);
                }
            }
            return back();
        } else {
            $errors = array('Not Allowed' => "You are not allowed to change your role please contact Administrator.");
            return back()->withErrors($errors);
        }
    }
}
