<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasMap;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    use HasMap;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function getImageMaxSize()
    {
        return config('road9.sysconfig.image_max_size');
    }

    protected function isUpdate()
    {
        return in_array($this->getMethod(), ['PATCH', 'PUT']);
    }
}
