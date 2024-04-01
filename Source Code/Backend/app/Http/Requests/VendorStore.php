<?php

namespace App\Http\Requests;

class VendorStore extends BaseRequest
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
            'name' => 'sometimes|required|string|max:255|unique:vendors',
            'email' => 'sometimes|required|email|string|max:255|unique:vendors',
            'type' => 'sometimes|required',
        ];

        if ($this->isUpdate() && $vendor = $this->route('vendor')) {
            $rules = array_merge($rules, [
                'name' => 'sometimes|required|string|max:255|unique:vendors,name,' . $vendor->id,
                'email' => 'sometimes|required|string|max:255|unique:vendors,email,' . $vendor->id,
            ]);
        }

        return $rules;
    }
}
