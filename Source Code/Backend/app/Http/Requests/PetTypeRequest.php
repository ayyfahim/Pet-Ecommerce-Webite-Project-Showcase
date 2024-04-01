<?php

namespace App\Http\Requests;

class PetTypeRequest extends BaseRequest
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
            // 'animal' => 'required',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
            ]);
        }
        return $rules;
    }
}
