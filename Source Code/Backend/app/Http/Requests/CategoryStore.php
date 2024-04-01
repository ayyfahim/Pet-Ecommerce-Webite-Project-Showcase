<?php

namespace App\Http\Requests;

class CategoryStore extends BaseRequest
{
    public function attributes()
    {
        return [
            'name.en' => 'English name',
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
            'name' => 'sometimes|required|string|max:255|unique:categories',
            'slug' => 'sometimes|nullable|string|max:255|unique:categories',
            'description' => 'sometimes|required|string|max:255',
        ];

        if ($this->isUpdate()) {
            $id = $this->route('category')->id;
            $rules = array_merge($rules, [
                'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $id,
                'slug' => 'sometimes|nullable|string|max:255|unique:categories,slug,' . $id,
            ]);
        }

        return $rules;
    }
}
