<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasPassword;

class UserAuth
{
    use HasPassword;

    public function passwordResetRules()
    {
        return array_merge($this->getPasswordRules(), [
            'token' => 'required',
            'email' => 'required|email',
        ]);
    }

    public function loginRules()
    {
        return [
            'email'    => 'required|email',
            'password' => $this->passwordRule(true),
        ];
    }
}
