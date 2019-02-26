<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email', 'invitation_token', 'registered_at'
    ];

    public function generateInvitationToken()
    {
        // change to use UUID generator package
        $this->invitation_token = substr(md5(rand(0, 9) . $this->email . time()), 0, 32);
        // $this->invitation_token = substr(bcrypt(rand(0,9) . $this->email . time()), 0, 32);
    }

    public function getLink()
    {
        return urldecode(route('register') . '?invitation_token=' . $this->invitation_token);
    }
}
