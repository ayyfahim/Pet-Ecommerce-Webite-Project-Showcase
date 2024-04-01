<?php

namespace App\Http\Requests;

class ReviewRequest extends BaseRequest
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
            'order_id' => 'required',
            'body' => 'required',
            'rate' => 'required|numeric|min:1|max:5',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
                'product_id' => 'nullable',
                'order_id' => 'nullable',
            ]);
        }
        return $rules;
    }
}
