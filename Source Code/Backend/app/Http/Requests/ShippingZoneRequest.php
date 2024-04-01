<?php

namespace App\Http\Requests;

class ShippingZoneRequest extends BaseRequest
{

    public function attributes()
    {
        return [
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'cities' => 'required',
            'regular_price' => 'required|numeric',
            'quick_price' => 'nullable|numeric',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
            ]);
        }
        return $rules;
    }
}
