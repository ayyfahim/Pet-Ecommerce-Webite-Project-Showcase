<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\HasTagGroups;

class ServiceStore extends BaseRequest
{
    use HasTagGroups {
        withValidator as public TagGroupWithValidator;
    }

    public function attributes()
    {
        return [
            'gallery.*' => 'gallery',
            'title.en' => 'title',
            'unit_type_status_id' => 'unit',
            'user_id' => 'provider',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max = config('road9.sysconfig.service.max_gallery_files');

        $rules = [
            'user_id' => 'sometimes|required',
            'category' => 'sometimes|required',
            'category_id' => 'sometimes|required',
            'title' => 'sometimes|arrayMinItems:1',
            'title.en' => 'sometimes|required|string|max:255',
            'title.ar' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|arrayMinItems:1',
            'description.*'=>'sometimes|nullable|string|max:1500',
            'cover' => 'required|image|max:' . $this->getImageMaxSize(),
            'gallery' => 'sometimes|array|max:' . $max,
            'gallery.*' => 'sometimes|image|max:' . $this->getImageMaxSize(),
            'delivery_days' => 'sometimes|required|numeric|min:1|digits_between:1,10',
            'unit_type_status_id' => 'sometimes|required',
            'min_units' => 'sometimes|required|numeric|min:1|digits_between:1,10',
            'price_per_unit' => 'sometimes|required|numeric|min:1|digits_between:1,10',
            'video_url' => 'sometimes|nullable|url',
        ];

        if ($this->isUpdate()) {
            $rules = array_merge($rules, [
                'cover' => 'sometimes|image|max:' . $this->getImageMaxSize(),
            ]);
        }

        return $rules;
    }

//    public function withValidator($validator)
//    {
//        if ($this->route('id') && $gallery = $this->gallery) {
//            $curr = $this->route('id')->gallery->count();
//
//            $validator->after(function ($validator) use ($gallery, $curr) {
//                $max = config('road9.sysconfig.service.max_gallery_files');
//                $avail = $max - $curr;
//                $msg = $avail > 0
//                    ? ", and you can only upload \"$avail\" more"
//                    : null;
//
//                if (count($gallery) > $avail) {
//                    $validator->errors()->add('gallery', "you already have \"$curr\" photos in your gallery{$msg}");
//                }
//            });
//        }
//
//        return $this->TagGroupWithValidator($validator);
//    }
}
