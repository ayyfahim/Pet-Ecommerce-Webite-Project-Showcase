<?php

namespace App\Http\Requests;

class StatusStore extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order'       => 'required|numeric|min:1',
            'wait_for'    => 'numeric|min:1',
            'model_name'  => 'required',
            'group_name'  => 'required',
            'title'       => 'arrayMinItems:1',
            'description' => 'arrayMinItems:1',
        ];
    }
}
