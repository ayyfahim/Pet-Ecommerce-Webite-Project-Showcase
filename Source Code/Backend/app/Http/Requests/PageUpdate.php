<?php

namespace App\Http\Requests;

class PageUpdate extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'slug' => 'sometimes|nullable|string|max:255|unique:pages',
        ];
        if ($this->isUpdate()) {
            $id = $this->route('page')->id;
            $rules = array_merge($rules, [
                'slug' => 'sometimes|nullable|string|max:255|unique:pages,slug,' . $id,
            ]);
        }
        return $rules;
    }
}
