<?php

namespace App\Models;



class AttributeOption extends BaseModel
{

    public $translatable = ['name'];
    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
}
