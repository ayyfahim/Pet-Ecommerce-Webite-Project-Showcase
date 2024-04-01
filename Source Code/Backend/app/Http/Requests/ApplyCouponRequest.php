<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ApplyCouponRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'code' => 'required',
            'products' => 'required|array',
            'products.*.id' => [
                'required',
                Rule::exists('products')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'products.*.quantity' => 'required|numeric|min:1|max:1000'
        ];

        return $rules;
    }
}
