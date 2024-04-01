<?php

namespace App\Http\Requests;

use App\Models\ProductList;
use Illuminate\Validation\Rule;

class CartStore extends BaseRequest
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
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1|max:1000'
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
                'product_id' => 'nullable',
            ]);
        }

        return $rules;
    }
}
