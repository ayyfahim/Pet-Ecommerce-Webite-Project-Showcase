<?php

namespace App\Models;

class AddressInfo extends BaseModel
{
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function city()
    {
        return $this->belongsTo(Status::class, 'city_id');
    }
}
