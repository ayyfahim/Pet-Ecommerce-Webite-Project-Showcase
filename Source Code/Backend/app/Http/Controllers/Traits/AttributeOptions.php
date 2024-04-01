<?php


namespace App\Http\Controllers\Traits;


use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

trait AttributeOptions
{
    /**
     * indexOptions.
     *
     * @param mixed $attribute
     * @return Factory|View
     */
    public function indexOptions(Attribute $attribute)
    {
        return view('pages.attributes.manager.options.index', [
            'attribute' => $attribute,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => "Attributes",
                    'route' => route('attribute.admin.index')
                ],
                [
                    'title' => $attribute->name,
                    'route' => route('attribute.admin.edit',$attribute->id)
                ]
            ], $attribute->name." Options"),
        ]);
    }

    /**
     * updateOptions.
     *
     * @param Request $request
     * @return void
     */
    public function updateOptions(Attribute $attribute,Request $request)
    {
        if ($attribute->type == 'dropdown' && $request->options) {
            $options_ids = [];
            foreach ($request->options as $option) {
                if (isset($option['name']) && ($option['name']['en'] || $option['name']['ar'])) {
                    if (isset($option['id'])) {
                        $options_ids[] = $option['id'];
                        // Update Option
                        $optionModel = $attribute->options()->find($option['id']);
                        if ($optionModel) {
                            $optionModel->update($option);
                        }
                    } else {
                        // Create Option
                        $optionCreated = $attribute->options()->create($option);
                        $options_ids[] = $optionCreated->id;
                    }
                }
            }
//            dd($attribute->options()->whereNotIn('id', $options_ids)->get());
            // Delete Options
            $attribute->options()->whereNotIn('id', $options_ids)->delete();
        }
        return $this->returnCrudData(__('system_messages.common.update_success'),url()->previous());
    }
}
