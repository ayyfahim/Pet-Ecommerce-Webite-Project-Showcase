<?php

namespace App\Http\Requests;

class RoleRequest extends BaseRequest
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
            'display_name' => 'required',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
            ]);
        }
        return $rules;
    }
}
