<?php

namespace App\Models\Traits;

use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;

trait HasStatus
{
    /**
     * get around the problem about caching and $with.
     */
    public static function bootHasStatus()
    {
        static::addGlobalScope('model-status', function (Builder $builder) {
            $builder->with(['status']);
        });
    }

    /* ========================================================================== */
    /*                                   HELPER                                   */
    /* ========================================================================== */

    public static function getStatusFor($item = null)
    {
        $q = Status::query()->where('model_name', self::getClassName());
        $q->when($item, function ($e) use ($item) {
            $e->where('group_name', $item);
        });

        return $item ? $q->get() : $q->get()->groupBy('group_name');
    }

    /* ========================================================================== */
    /*                                  RELATION                                  */
    /* ========================================================================== */

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function scopeIsActive($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('order', 1);
        });
    }
    public function getIsActiveAttribute()
    {
        return $this->status->order == 1;
    }
}
