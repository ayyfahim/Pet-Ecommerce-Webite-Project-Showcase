<?php

namespace App\Policies;

trait BeforeTrait
{
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}
