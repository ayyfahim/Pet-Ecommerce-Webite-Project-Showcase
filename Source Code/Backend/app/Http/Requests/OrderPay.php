<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class OrderPay extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'address_info_id' => [
                'required',
                Rule::exists('address_infos', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                })
            ],
            'payment_type' => 'required|in:card,paypal',
            'clientSecret' => 'required',

            'email' => 'required|email|max:255',
            'full_name' => 'required|string',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ];

        return $rules;
    }
}
