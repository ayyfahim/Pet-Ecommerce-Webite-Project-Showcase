<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * https://gistlog.co/alesf/89b3b5fdd2eb73afe227.
 *
 * dont forget to add the relation name
 * you want to cascade on restore
 */
trait HasSoftDeletes
{
    use SoftDeletes;

    public static function bootHasSoftDeletes()
    {
//        static::addGlobalScope('includeDeleted', function (Builder $builder) {
//            $builder->withoutGlobalScope(SoftDeletingScope::class);
//        });

        static::restoring(function ($model) {
            $relations = $model->deleteCascade;

            if ($relations) {
                foreach ($relations as $relation) {
                    $related = $model->$relation();

                    if (
                        in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($related)) &&
                        !$related->forceDeleting
                    ) {
                        $related->withTrashed()->restore();
                    }
                }
            }
        });
    }
}
