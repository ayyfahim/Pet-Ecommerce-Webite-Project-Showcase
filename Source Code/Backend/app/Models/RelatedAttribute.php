<?php

namespace App\Models;



class RelatedAttribute extends BaseModel
{

    public $translatable = ['value'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function configurations()
    {
        return $this->hasMany(RelatedAttributeConfiguration::class)->orderBy('created_at');
    }

}
