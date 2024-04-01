<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class OrderPayCheckout extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email|max:255',
            'full_name' => 'nullable|string',
            'mobile' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'products' => 'required|array',
            'products.*.id' => [
                'required',
                Rule::exists('products')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'products.*.quantity' => 'required|numeric|min:1|max:1000',

            'street_address' => 'sometimes|required',
            'city' => 'sometimes|required',
            'country' => 'sometimes|required',
            'postal_code' => 'sometimes|required',
            'payment_type' => 'required|in:card,paypal',
        ];

        return $rules;
    }
}
