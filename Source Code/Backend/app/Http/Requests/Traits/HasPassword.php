<?php

namespace App\Http\Requests\Traits;

use App\Rules\MatchOldPassword;

trait HasPassword
{
    protected function passwordRule($login)
    {
        return $login
            ? 'sometimes|required'
            : 'sometimes|required|min:8'; // pwned|dumbpwd
    }

    protected function passwordConfirmRule()
    {
        return 'sometimes|required|same:password';
    }

    protected function getPasswordRules($login = false)
    {
        return [
            'current_password' => ['sometimes', 'required', new MatchOldPassword()],
            'password' => $this->passwordRule($login),
            'password_confirmation' => $this->passwordConfirmRule(),
        ];
    }
}
