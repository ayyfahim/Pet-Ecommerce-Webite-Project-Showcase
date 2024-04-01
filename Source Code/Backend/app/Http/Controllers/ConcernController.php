<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Brand;
use App\Models\Concern;
use App\Transformers\BrandTransformer;
use App\Transformers\ConcernTransformer;
use Illuminate\Http\Response;
use App\Transformers\PageTransformer;
use Illuminate\Support\Facades\Request;

/**
 * @group System-Pages
 */
class ConcernController extends Controller
{
    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        return $this->returnCrudData(__('system_messages.common.update_success'), '', 'success', [
            'concerns' => fractal(Concern::all(), new ConcernTransformer())->toArray()['data']
        ]);
    }

    public function show($slug, Request $request)
    {
        $category = Concern::where('slug', $slug)->firstOrFail();
        if (!$category) {
            abort(404);
        }

        return response()->json([
            'concern' => fractal($category, new ConcernTransformer())->toArray()['data']
        ]);
    }
}
