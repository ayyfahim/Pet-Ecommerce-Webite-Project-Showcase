<?php

namespace App\Http\Requests;

class DealRequest extends BaseRequest
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
            'product_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'from' => 'required|date',
            'to' => 'required|date',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
            ]);
        }
        return $rules;
    }
}
