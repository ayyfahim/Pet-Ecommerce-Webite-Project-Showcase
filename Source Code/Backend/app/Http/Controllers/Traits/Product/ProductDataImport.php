<?php


namespace App\Http\Controllers\Traits\Product;


use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

trait ProductDataImport
{
    /**
     * import.
     *
     * @param Request $request
     * @return Factory|View
     * @throws \Throwable
     */
    public function importStore(Request $request)
    {
        ini_set('max_execution_time', 20);

        if ($request->hasFile('file')) {
            $fileNameToStore = time() . '.' . $request->file('file')->getClientOriginalExtension();
            $path = $request->file('file')->storeAs('import', $fileNameToStore);
            $fh = fopen(storage_path('app/public/' . $path), "r");
            $headers = fgetcsv($fh, 0, ",");
            $data = [];
            while (($row = fgetcsv($fh, 0, ",")) !== FALSE) {
                $data[] = collect(array_combine($headers, $row));
            }
            foreach ($data as $item) {
                $item = collect($item);
                $productData = $item->only(
                    'sku', 'quantity', 'supplier_code', 'google_category', 'additional_categories', 'affiliate_link',
                    'show_brand', 'notes', 'shipping_cost', 'shipping_days'
                )->toArray();
                $productData['slug'] = $item['title'];
                $productData['featured'] = $item['featured'] == "1";
                $productData['status_id'] = $item['active'] == "1"
                    ? Product::getStatusFor('status')->firstWhere('order', 1)->id
                    : Product::getStatusFor('status')->firstWhere('order', 2)->id;
                $productInfoData = $item->only(
                    'title', 'supplier_regular_price', 'regular_price', 'sale_price',
                    'video_url', 'excerpt', 'description', 'delivery_information',
                    'warranty_information', 'terms_conditions'
                )->toArray();
                $productInfoData = array_merge($productInfoData, [
                    'brand_id' => $this->importGetBrandId($item['brand']),
                    'vendor_id' => $this->importGetVendorId($item['supplier']),
                ]);
                DB::transaction(function () use ($productData, $productInfoData, $item) {
                    if ($product = $this->importGetProduct($item['sku'])) {
                    } else {
                        $product = $this->importCreateProduct([
                            'product_data' => $productData,
                            'product_info_data' => $productInfoData,
                            'categories' => $item['categories'],
                            'gallery' => $item['gallery'],
                        ]);
                    }
                });
            }
            Storage::disk('public')->delete($path);
        }
        return $this->returnCrudData('Imported Successfully', route('product.admin.index'));
    }

    private function importGetProduct($sku)
    {
        return Product::where('sku', $sku)->first();
    }

    private function importCreateProduct($data)
    {
        $product = Product::create($data['product_data']);
        $info = $product->infos()->create($data['product_info_data']);
        if ($categories = $this->importGetCategoryId(preg_split('/(\n|\r)+/', $data['categories']))) {
            $info->categories()->sync($categories);
        }
        if ($data['gallery']) {
            foreach (explode(',', $data['gallery']) as $key => $image) {
                try {
                    if (filter_var($image, FILTER_VALIDATE_URL)) {
                        $product->addHashedMediaFromUrl($image, ['main' => $key == 0])
                            ->toMediaCollection('gallery');
                    } else {
                        $product->addHashedMedia(storage_path('import\\' . $image), true, ['main' => $key == 0])
                            ->preservingOriginal()
                            ->toMediaCollection('gallery');
                    }
                } catch (\Exception $exception) {

                }
            }
        }
        $this->setFiltrationColumns($product->fresh());
        return $product;
    }

    private function importGetCategoryId($categories)
    {
        $response = [];
        foreach ($categories as $category) {
            $categoryObj = null;
            $categoriesArr = explode("/", $category);
            foreach ($categoriesArr as $key => $item) {
                $data = ['name' => $item];
                if ($key > 0 && $categoryObj) {
                    $data['parent_id'] = $categoryObj->id;
                }
                $categoryObj = Category::where('name', $category)->first();
                if (!$categoryObj) {
                    $categoryObj = Category::create($data);
                }
                if ($key === array_key_last($categoriesArr)) {
                    $response[] = $categoryObj->id;
                }
            }
        }
        return $response;
    }

    private function importGetBrandId($name)
    {
        $brand = Brand::where('name', $name)->first();
        if (!$brand) {
            $brand = Brand::create(['name' => $name]);
        }
        return $brand->id;
    }

    private function importGetVendorId($name)
    {
        $vendor = Vendor::where('name', $name)->first();
        if (!$vendor) {
            $vendor = Vendor::create(['name' => $name,'company_name'=>$name]);
        }
        return $vendor->id;
    }

    private function importGetAttributeId($name, $configured = false)
    {
        $attribute = Attribute::where('configured', $configured)->where(function ($query) use ($name) {
            $query->where('name->en', $name)->orWhere('name->ar', $name);
        })->first();
        if (!$attribute) {
            $attribute = Attribute::create([
                'name' => array_fill_keys(['en', 'ar'], $name),
                'type' => 'text',
                'configured' => $configured
            ]);
        }
        return $attribute->id;
    }
}
