<?php

namespace App\Transformers;

use App\Models\Attribute;
use App\Models\RelatedAttribute;

class AttributeTransformer extends BaseTransformer
{
    /**
     * A Fractal transformer.
     *
     * @param RelatedAttribute $productAttribute
     * @return void
     */
    public function transform(RelatedAttribute $productAttribute)
    {
        $data = [
            'id' => $productAttribute->id,
            'label' => $productAttribute->attribute->name,
            'type' => $productAttribute->attribute->name == 'Color' ? 'color' : 'text'
        ];
        if ($productAttribute->attribute->configured) {
            $options = [];
            foreach ($productAttribute->configurations as $configuration) {
                $item = [
                    'id' => $configuration->id,
                    'value' => $configuration->value,
                    'color_name' => $data['type'] == 'color' ? get_color_name($configuration->value) : ''
                ];
                $options[] = $item;
            }
            $data['options'] = $options;
        } else {
            $data = array_merge($data, [
                'value' => $productAttribute->value
            ]);
        }
        return $data;
    }
}
