<?php

namespace App\Models;

class Categorisable extends BaseModel
{

    /* ========================================================================== */
    /*                                  RELATIONS                                 */
    /* ========================================================================== */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function categorisable()
    {
        return $this->morphTo();
    }

    public function getCategorisableTypeClassAttribute()
    {
        return class_basename($this->categorisable_type);
    }

}
