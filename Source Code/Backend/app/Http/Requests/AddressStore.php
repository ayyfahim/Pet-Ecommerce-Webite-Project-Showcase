<?php

namespace App\Http\Requests;

class AddressStore extends BaseRequest
{
    public function attributes()
    {
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'sometimes',
            'title' => 'sometimes',
            'email' => 'sometimes|email',
            'phone' => 'sometimes',
            'street_address' => 'sometimes',
            'area' => 'sometimes',
            'city' => 'sometimes',
            'country' => 'sometimes',
            'postal_code' => 'sometimes',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, []);
        }

        return $rules;
    }
}
