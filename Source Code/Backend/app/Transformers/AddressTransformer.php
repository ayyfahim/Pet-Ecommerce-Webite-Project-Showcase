<?php

namespace App\Transformers;

use App\Models\Address;
use App\Transformers\Traits\HasMap;

class AddressTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Address $address
     * @return array
     */
    public function transform(Address $address)
    {
        return [
            'id' => $address->id,
            'address_info_id' => $address->info->id,
            'title' => $address->info->title,
            'name' => $address->info->name,
            'business_name' => $address->info->business_name,
            'email' => $address->info->email,
            'phone' => $address->info->phone,
            'street_address' => $address->info->street_address,
            'area' => $address->info->area,
            'city' => $address->info->city,
            'country' => $address->info->country,
            'postal_code' => $address->info->postal_code,
            'default' => $address->default,
            'place_id' => $address->info->place_id,
        ];
    }
}
