<?php

namespace App\Http\Requests;

class AuthorRequest extends BaseRequest
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
            'name' => 'sometimes|required',
            'title' => 'sometimes|required',
            'bio' => 'sometimes|required',
        ];
        return $rules;
    }
}
