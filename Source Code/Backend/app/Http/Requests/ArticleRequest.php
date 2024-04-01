<?php

namespace App\Http\Requests;

class ArticleRequest extends BaseRequest
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
            'title' => 'sometimes|required',
            'content' => 'sometimes|required',
            'slug' => 'sometimes|nullable|string|max:255|unique:articles',
        ];
        if ($this->isUpdate()) {
            $id = $this->route('article')->id;
            $rules = array_merge($rules, [
                'slug' => 'sometimes|nullable|string|max:255|unique:articles,slug,' . $id,
            ]);
        }
        return $rules;
    }
}
