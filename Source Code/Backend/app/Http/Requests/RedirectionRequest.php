<?php

namespace App\Http\Requests;

class RedirectionRequest extends BaseRequest
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
            'from' => 'sometimes|required',
            'to' => 'sometimes|required',
            'status_id' => 'sometimes|required',
            'type' => 'sometimes|required',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
            ]);
        }
        return $rules;
    }
}
