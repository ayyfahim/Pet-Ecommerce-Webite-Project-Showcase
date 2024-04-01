<?php

namespace App\Models;

use App\Models\Traits\ModelCommon;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class BaseModel extends Model
{
    use ModelCommon, HasRelationships, BelongsToThrough;

    protected $guarded = ['id'];
    public function getShortIdAttribute()
    {
        return explode('-', $this->id)[0];
    }
}
