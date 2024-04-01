<?php

namespace App\Http\Controllers;

use Spatie\MediaLibrary\Models\Media;

/**
 * @group Media
 */
class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * destroy.
     *
     * @param Media $id
     */
    public function destroy(Media $id)
    {
        $id->delete();

        return $this->returnCrudData('media item removed');
    }
}
