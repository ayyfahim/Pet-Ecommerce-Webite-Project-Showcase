<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Transformers\PageTransformer;
use Illuminate\Http\Response;

/**
 * @group System-Pages
 */
class PageController extends Controller
{
    /**
     * show.
     *
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        $page = Page::findBySlug($slug);
        return response()->json([
            'page' => fractal($page, new PageTransformer(true))->toArray()['data'],
        ]);

    }
}
