<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProductStore extends BaseRequest
{
    public function attributes()
    {
        return [
            'cover' => 'main image',
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
            'title' => 'sometimes|required',
            'slug' => 'sometimes|nullable|string|max:255|unique:products',
//            'description' => 'sometimes|required',
//            'categories' => 'nullable',
            'quantity' => 'sometimes|nullable|numeric',
            'regular_price' => 'sometimes|nullable|numeric',
            'sale_price' => 'sometimes|nullable|numeric|lt:regular_price',
            'video_url' => 'sometimes|nullable|url',
            'cover' => 'nullable',
            'voucher_code' => [
                'sometimes',
                'nullable',
                Rule::unique('product_infos')->whereNull('deleted_at')
            ],
        ];

        if ($this->isUpdate()) {
            $product = $this->route('product');
            $rules = array_merge($rules, [
                'slug' => 'sometimes|nullable|string|max:255|unique:products,slug,' . $product->id,
                'voucher_code' =>[
                    'sometimes',
                    'nullable',
//                    Rule::unique('product_infos')->ignore($product->info->id)->whereNull('deleted_at')
                ],
            ]);
        }

        return $rules;
    }
}
