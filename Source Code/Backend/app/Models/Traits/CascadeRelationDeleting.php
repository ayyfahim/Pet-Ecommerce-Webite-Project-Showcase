<?php

namespace App\Models\Traits;

/**
 * auto delete related models.
 *
 * dont forget to include
 * protected $deleteCascade = ['relation_name'];
 *
 * @return [type] [return description]
 */
trait CascadeRelationDeleting
{
    public static function bootCascadeRelationDeleting()
    {
        // cascade relation deletion
        static::deleting(function ($model) {
            $relations = $model->deleteCascade;

            if ($relations) {
                foreach ($relations as $relation) {
                    if ($model->$relation()->count()) {
                        if ($model->forceDeleting) {
                            $model->$relation()->forceDelete();
                        } else {
                            $model->$relation()->delete();
                        }
                    }
                }
            }
        });
    }
}
