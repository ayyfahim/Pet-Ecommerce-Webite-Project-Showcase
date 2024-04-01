<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CouponRequest extends BaseRequest
{
    public function attributes()
    {
        return [
            'title.en' => 'English title',
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
            'uses' => 'sometimes|required|numeric',
            'from' => 'sometimes|required|date',
            'to' => 'sometimes|required|date|after_or_equal:from',
            'code' => [
                'sometimes',
                'required',
                Rule::unique('coupons')->whereNull('deleted_at')
            ],
            'discount_type' => 'sometimes|required',
            'discount_amount' => 'sometimes|required|numeric',
            'uses_per_coupon' => 'sometimes|required|numeric',
            'uses_per_customer' => 'sometimes|required|numeric',
        ];
        if ($this->isUpdate() && $coupon = $this->route('coupon')) {
            $rules = array_merge($rules, [
                'code' =>[
                    'sometimes',
                    'required',
                    Rule::unique('coupons')->ignore($coupon->id)->whereNull('deleted_at')
                ],
            ]);
        }
        return $rules;
    }
}
