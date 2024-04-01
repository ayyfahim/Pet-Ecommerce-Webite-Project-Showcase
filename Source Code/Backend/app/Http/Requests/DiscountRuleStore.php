<?php

namespace App\Http\Requests;

class DiscountRuleStore extends BaseRequest
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
            'title' => 'sometimes|arrayMinItems:1',
            'title.en' => 'sometimes|required|string|max:255',
            'title.ar' => 'sometimes|nullable|string|max:255',
            'uses' => 'sometimes|required|numeric',
            'from' => 'sometimes|required|date',
            'to' => 'sometimes|required|date|after_or_equal:from',
            'rule' => 'sometimes|required',
            'priority' => 'sometimes|required|numeric',
            'target' => 'sometimes|required|numeric',
            'discount_type' => 'sometimes|required',
            'discount_amount' => 'sometimes|required|numeric',
        ];

        return $rules;
    }
}
