<?php


namespace Crm\OAuth;

use Illuminate\Support\Facades\Auth;

class Verifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'username'    => $username,
            'password' => $password,
        ];

        if( Auth::validate($credentials)) {
            $user = \Crm\Entities\User::where('username', $username)->first();

            return $user->id;
        }




        return false;
    }
}