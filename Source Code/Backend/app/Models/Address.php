<?php

namespace App\Models;

use App\User;

class Address extends BaseModel
{
    protected $casts = [
        'default' => 'boolean',
    ];
    public function infos()
    {
        return $this->hasMany(AddressInfo::class);
    }

    public function info()
    {
        return $this->infos()->latest()->toHasOne();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
