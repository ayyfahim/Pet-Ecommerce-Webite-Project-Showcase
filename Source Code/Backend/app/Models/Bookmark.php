<?php

namespace App\Models;

use App\User;
use App\Models\Traits\HasSortings;

class Bookmark extends BaseModel
{
    use HasSortings;
    protected static $sorting_options = [4, 9];
    /* ========================================================================== */
    /*                                  RELATIONS                                 */
    /* ========================================================================== */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
