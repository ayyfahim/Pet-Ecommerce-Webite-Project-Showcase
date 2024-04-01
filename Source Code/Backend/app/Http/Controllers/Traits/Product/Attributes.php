<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 9/28/2020
 * Time: 2:13 PM
 */

namespace App\Http\Controllers\Traits\Product;


use App\Models\Attribute;
use App\Models\Product;
use App\Models\RelatedAttributeConfiguration;
use Illuminate\Http\Request;

trait Attributes
{
    public function getAttribute(Request $request)
    {
        $product = Product::find($request->product_id);
        $attribute = Attribute::findOrFail($request->attribute_id);
        return $this->returnCrudData('', null, 'success', [], (string)view('pages.products.manager.partials.form-items.attribute-wrapper', [
            'model' => $product,
            'attribute' => $attribute,
            'attributeMainKey' => $request->index,
        ]));
    }

    private function setAttributes($attributes, $model, $options_to_delete = null)
    {
        if ($attributes) {
            if (isset($attributes['specifications'])) {
                $this->setSpecifications($attributes['specifications'], $model);
            }
        }
        $this->setConfigurations($attributes['configurations'] ?? [], $model, $options_to_delete);
    }

    private function setSpecifications($attributes, $model)
    {
        if ($attributes) {
            foreach ($attributes as $attribute) {
                if (isset($attribute['id'])) {
                    // Update Attribute
                    $attributeModel = $model->attributes()->find($attribute['id']);
                    if ($attributeModel) {
                        $attributeModel->update($attribute);
                    }
                } else {
                    // Create Attribute
                    $model->attributes()->create($attribute);
                }
            }
        }
    }

    private function setConfigurations($attributes, $model, $options_to_delete = null)
    {
        $ids = [];
        if ($attributes) {
            foreach ($attributes as $attribute) {
                // Create Attribute
                if (isset($attribute['id'])) {
                    $model_attribute = $model->attributes()->find($attribute['id']);
                } else {
                    if (isset($attribute['options'])) {
                        if (!(sizeof($attribute['options']) && $attribute['options'][0]['value'])) {
                            continue;
                        }
                    } else {
                        continue;
                    }
                    $model_attribute = $model->attributes()->create([
                        'attribute_id' => $attribute['attribute_id']
                    ]);
                }
                $ids[] = $model_attribute->id;
                if (isset($attribute['options'])) {
                    foreach ($attribute['options'] as $configuration) {
                        if ($configuration['value']) {
                            if (isset($configuration['id'])) {
                                // Update Option
                                $configurationModel = RelatedAttributeConfiguration::find($configuration['id']);
                                if ($configurationModel) {
                                    $configurationModel->update($configuration);
                                }
                            } else {
                                // Create Option
                                $model_attribute->configurations()->create($configuration);
                                sleep(1);
                            }
                        }
                    }
                }
                // Delete Options
                if ($options_to_delete) {
                    RelatedAttributeConfiguration::whereIn('id', $options_to_delete)->delete();
                }
            }
        }
        if ($ids) {
            $model->attributes()->whereNotIn('id', $ids)->delete();
        } else {
            $model->attributes()->delete();
        }
    }
}
