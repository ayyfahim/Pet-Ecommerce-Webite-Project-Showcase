<?php

namespace App\Models;


use App\Models\Traits\HasSoftDeletes;

class ProductIcon extends BaseModel
{
    use HasSoftDeletes;
    protected $casts = [
        'listing' => 'boolean',
        'enabled' => 'boolean',
    ];

    public function icon()
    {
        return $this->belongsTo(Icon::class)->whereNull('deleted_at');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
