<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Invitation;

class HasInvitation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * Only for GET requests. Otherwise, this middleware will block our registration.
         */
        if ($request->isMethod('get')) {
            /**
             * No Token = Goodbye.
             */
            if (!$request->has('invitation_token')) {
                return redirect(route('requestInvitation'));
            }

            $invitation_token = $request->get('invitation_token');

            try {
                $invitation = Invitation::where('invitation_token', $invitation_token)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return redirect(route('requestInvitation'))
                    ->with('error', 'Wrong invitation token! Please check your URL.');
            }

            /**
             * Let's check if user already registred.
             * If yes -> redirect to login with error.
             */
            if (!is_null($invitation->registered_at)) {
                return redirect(route('login'))->with('error', 'The invitation link has already been used.');
            }
            return $next($request);
        }
    }
}
