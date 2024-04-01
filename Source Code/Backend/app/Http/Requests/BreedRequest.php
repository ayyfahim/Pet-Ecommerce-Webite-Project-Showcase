<?php

namespace App\Http\Requests;

class BreedRequest extends BaseRequest
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
            'name' => 'required',
            'pet_type_id' => 'required',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
            ]);
        }
        return $rules;
    }
}
