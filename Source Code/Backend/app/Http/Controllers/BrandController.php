<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Brand;
use App\Transformers\BrandTransformer;
use Illuminate\Http\Response;
use App\Transformers\PageTransformer;
use Illuminate\Support\Facades\Request;

/**
 * @group System-Pages
 */
class BrandController extends Controller
{
    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        return $this->returnCrudData(__('system_messages.common.update_success'), '', 'success', [
            'brands' => fractal(Brand::all(), new BrandTransformer())->toArray()['data']
        ]);
    }
}
