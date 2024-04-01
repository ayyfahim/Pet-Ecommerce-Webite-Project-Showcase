<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ContactUsRequest extends BaseRequest
{
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
            'message' => 'required|string',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ];

        return $rules;
    }
}
