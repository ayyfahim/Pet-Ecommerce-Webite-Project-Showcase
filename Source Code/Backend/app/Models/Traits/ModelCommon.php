<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Dyrynda\Database\Support\GeneratesUuid;

/**
 * put here anything that is common between
 * BaseModel & User model.
 */
trait ModelCommon
{
    use GeneratesUuid,
        CascadeRelationDeleting;
    /* -------------------------------------------------------------------------- */
    /*                                   UUID                                     */
    /* -------------------------------------------------------------------------- */

    public function getIncrementing()
    {
        return false;
    }

    public function uuidColumn()
    {
        return 'id';
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
}
