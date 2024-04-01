<?php

namespace App\Http\Requests;

use App\Models\ProductList;
use Illuminate\Validation\Rule;

class ProductListStore extends BaseRequest
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
            'product_id' => 'sometimes|required',
            'type' => [
                'sometimes',
                'required',
                Rule::in(app(ProductList::class)->types),
            ],
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
