<?php

namespace App\Http\Requests;

class RewardPointStore extends BaseRequest
{

    public function attributes()
    {
        return [
            'user_id' => 'user'
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
            'user_id' => 'required',
            'points' => 'required|numeric',
        ];
        return $rules;
    }
}
