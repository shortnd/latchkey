<?php

namespace App\Http\Controllers;

use App\Invitation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvitationRequest;

class InvitationsController extends Controller
{
    public function showRequestedInvitations()
    {
        $invitations = Invitation::where('registered_at', null)->orderBy('created_at', 'desc')->get();
        return view('invitations.index')->withInvitations($invitations);
    }
    public function store(StoreInvitationRequest $request)
    {
        $invitation = new Invitation($request->only('email'));
        $invitation->generateInvitationToken();
        $invitation->save();

        return redirect()->route('requestInvitation')
            ->with('success', 'Invitation to register successfully requested. Please wait for registration link.');
    }
}
