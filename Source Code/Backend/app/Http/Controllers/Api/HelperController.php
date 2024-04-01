<?php

namespace App\Http\Controllers\Api;

use App\Acme\Core;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ConfigData;
use App\Models\Earning;
use App\Models\Order;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Rfp;
use App\Models\RfpProposal;
use App\Models\ServiceInfo;
use App\Models\ServiceRequest;
use App\Models\ShippingZone;
use App\Models\Vendor;
use App\Transformers\BrandTransformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\ConfigTransformer;
use App\Transformers\PageTransformer;
use App\Transformers\ProductTransformer;
use App\Transformers\StatusTransformer;
use App\Transformers\VendorTransformer;
use Illuminate\Support\Arr;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * @group Helpers
 */
class HelperController extends Controller
{
    protected $helper;

    public function __construct(Core $helper)
    {
        $this->helper = $helper;
    }

    /**
     * generic data.
     */
    public function getGlobalData()
    {
        $pages = [];
        foreach (Page::isActive()->get()->sortBy('order')->groupBy('category') as $type => $type_pages) {
            $pages[] = [
                'category' => $type,
                'pages' => fractal($type_pages,PageTransformer::class)->toArray()['data'],
            ];
        }
        $data = [
            'categories' => fractal(Category::isActive()->whereIsRoot()->orderByRaw('-sort_order DESC')->get(), new CategoryTransformer())->toArray()['data'],
            'pages' => $pages,
            'order' => [
                'shipping_methods' => fractal(Order::getStatusFor('shipping_method'), StatusTransformer::class)->toArray()['data'],
                'payment_methods' => fractal(Order::getStatusFor('payment_method'), StatusTransformer::class)->toArray()['data'],
            ],
            'config' => fractal(ConfigData::whereIn('group', ['site_settings', 'social_media', 'contact'])->get()->sortBy('order'), new ConfigTransformer())->toArray()['data']
        ];
        return response()->json($data);
    }
}
