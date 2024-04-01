<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class VariationOption extends BaseModel
{
    public function variation()
    {
        return $this->belongsTo(Variation::class,'variation_id');
    }

    public function option()
    {
        return $this->belongsTo(RelatedAttributeConfiguration::class, 'option_id');
    }
}
