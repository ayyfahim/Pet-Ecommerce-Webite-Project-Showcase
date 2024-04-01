<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasPassword;
use App\Models\Product;
use Illuminate\Validation\Rule;

class UserCartStore extends BaseRequest
{
    use HasPassword;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email|max:255',
            'full_name' => 'required|string',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'products' => 'required|array',
            'products.*.id' => [
                'required',
                Rule::exists('products')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'products.*.quantity' => 'required|numeric|min:1|max:1000',

            'street_address' => 'sometimes',
            'city' => 'sometimes',
            'country' => 'sometimes',
            'postal_code' => 'sometimes',
        ];
        return $rules;
    }
}
