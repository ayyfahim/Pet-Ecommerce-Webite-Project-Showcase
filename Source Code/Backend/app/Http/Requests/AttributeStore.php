<?php

namespace App\Http\Requests;

class AttributeStore extends BaseRequest
{
    public function attributes()
    {
        return [
            'name.en' => 'English name',
            'badge' => 'image',
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
            'name' => 'required|string|max:255',
        ];
        return $rules;
    }
}
