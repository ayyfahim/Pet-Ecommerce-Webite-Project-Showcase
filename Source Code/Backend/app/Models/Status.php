<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $guarded = ['id'];
    protected $casts = ['is_active' => 'boolean'];

    /**
     * global scope.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('defaultOrder', function (Builder $builder) {
            $builder
                ->where('is_active', 1)
                ->orderBy('model_name')
                ->orderBy('group_name')
                ->orderBy('order');
        });
    }
    /* -------------------------------------------------------------------------- */
    /*                                   ACCESSOR                                 */
    /* -------------------------------------------------------------------------- */

    public function getModelClassNameAttribute()
    {
        return class_basename($this);
    }

    public function getFullModelClassNameAttribute()
    {
        return get_called_class();
    }

    /* -------------------------------------------------------------------------- */
    /*                                   HELPERS                                  */
    /* -------------------------------------------------------------------------- */

    /**
     * get the class name of the calling model
     * ex. "Model::getClassName();".
     *
     * @param bool $FQN
     * @return string
     */
    protected static function getClassName($FQN = false)
    {
        return $FQN ? get_called_class() : class_basename(get_called_class());
    }

    public function getArrayFor($attr)
    {
        $val = $this->$attr;

        return is_array($val) ? $val : [$val];
    }
    /* ========================================================================== */
    /*                                  MUTATORS                                  */
    /* ========================================================================== */

}
