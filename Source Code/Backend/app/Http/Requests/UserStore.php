<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasPassword;

class UserStore extends BaseRequest
{
    use HasPassword;

    public function attributes()
    {
        return [
            'categories.*' => 'categories',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = array_merge($this->getPasswordRules(false), [
            'full_name' => 'sometimes|required|string',
            'email' => 'required|email|max:255|unique:users', // isValid
            'mobile' => 'sometimes|required|unique:users,mobile',
            'role_id' => 'sometimes|required',
        ]);

        if ($this->isUpdate()) {
            $user = $this->route('user') ?: auth()->user();
            $id = $user->id;
            $rules = array_merge($rules, [
                'locale' => 'sometimes|required',
                'email' => 'sometimes|required|email|max:255|unique:users,email,' . $id, // isValid
                'password' => 'sometimes|nullable|min:8', // pwned|dumbpwd
                'password_confirmation' => 'sometimes|nullable|same:password',
                'mobile' => 'sometimes|required|unique:users,mobile,' . $id,
                'avatar' => 'nullable|image|max:' . $this->getImageMaxSize(),
            ]);
        }
        return $rules;
    }
}
