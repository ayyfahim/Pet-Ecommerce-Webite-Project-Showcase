<?php

namespace App\Http\Requests;

class EventRequest extends BaseRequest
{

    public function attributes()
    {
        return [
            'title.en' => "English Title",
            'link.*' => "Link",
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
            'title.en' => 'required',
            'link.*' => 'nullable|url',
        ];
        return $rules;
    }
}
