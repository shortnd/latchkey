<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // see about also checks users and throws error if its there also
            'email' => 'required|email|unique:invitations'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Invitation with this email address already requested.'
        ];
    }
}
