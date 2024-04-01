<?php

namespace App\Models;


class CartBasketOption extends BaseModel
{
    protected $table = 'cart_product_options';

    public function cart_product()
    {
        return $this->belongsTo(CartBasket::class, 'cart_product_id');
    }

    public function option()
    {
        return $this->belongsTo(RelatedAttributeConfiguration::class, 'option_id');
    }

    public function getLabelAttribute()
    {
        $value = $this->option->option ? $this->option->option->name : $this->option->value;
        try {
            if ($this->option->product_attribute->attribute->name == 'Color') {
                $value = get_color_name($value);
//                $value = "<span style='width: 50px;height: 50px;background: #".$value."'></span>";
            }
        } catch (\Exception $exception) {

        }
        return $value;
    }
}
