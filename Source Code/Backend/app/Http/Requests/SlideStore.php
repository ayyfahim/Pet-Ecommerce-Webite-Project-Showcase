<?php

namespace App\Http\Requests;

class SlideStore extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'      => 'arrayMinItems:1',
            'btn_text'   => 'required',
            'route_name' => 'required',
            'cover'      => 'image|max:' . $this->getImageMaxSize(),
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
                'title'      => 'arrayMinItems:1',
                'btn_text'   => 'sometimes|required',
                'route_name' => 'sometimes|required',
                'cover'      => 'image|max:' . $this->getImageMaxSize(),
            ]);
        }

        return $rules;
    }
}
