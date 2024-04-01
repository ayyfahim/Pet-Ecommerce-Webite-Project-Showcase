<?php

namespace App\Http\Requests;

class BrandStore extends BaseRequest
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
            'name' => 'sometimes|required|string|max:255|unique:brands',
            'slug' => 'sometimes|nullable|string|max:255|unique:brands',
        ];
        if ($this->isUpdate()) {
            $id = $this->route('brand')->id;
            $rules = array_merge($rules, [
                'name' => 'sometimes|required|string|max:255|unique:brands,name,' . $id,
                'slug' => 'sometimes|nullable|string|max:255|unique:brands,slug,' . $id,
            ]);
        }
        return $rules;
    }
}
