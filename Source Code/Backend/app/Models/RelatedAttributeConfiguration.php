<?php

namespace App\Models;


class RelatedAttributeConfiguration extends BaseModel
{

    public function product_attribute()
    {
        return $this->belongsTo(RelatedAttribute::class,'related_attribute_id');
    }
    public function getAttributeNameAttribute()
    {
        if ($product_attribute = $this->product_attribute) {
            if ($attribute = $product_attribute->attribute) {
                return $attribute->name;
            }
        }
    }

}
