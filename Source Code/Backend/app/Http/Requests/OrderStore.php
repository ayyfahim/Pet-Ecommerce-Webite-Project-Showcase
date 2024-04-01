<?php

namespace App\Http\Requests;

class OrderStore extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'payment_method_id' => 'required',
            'shipping_method_id' => 'required',
            'address_info_id' => 'required',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
                'payment_method_id' => 'nullable',
                'shipping_method_id' => 'nullable',
                'address_info_id' => 'nullable',
                'notification_id' => 'sometimes|required'
            ]);
        }

        return $rules;
    }
}
