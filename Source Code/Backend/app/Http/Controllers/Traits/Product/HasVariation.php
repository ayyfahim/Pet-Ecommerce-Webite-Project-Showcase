<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 9/28/2020
 * Time: 1:35 PM
 */

namespace App\Http\Controllers\Traits\Product;


use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;

trait HasVariation
{
    public function addVariation(Product $product)
    {
        $variation = $product->variations()->create();
        return $this->returnCrudData('', null, 'success', [], (string)view('pages.products.manager.partials.form-items.variation-item', [
            'product' => $product,
            'variation' => $variation,
            'variationKey' => $product->variations()->count() - 1
        ]));
    }

    public function setVariations($variations, Product $product, $variations_to_delete = null)
    {
        if ($variations) {
            foreach ($variations as $variation) {
                if (isset($variation['options'])) {
                    $ids = [];
                    $variationObj = Variation::findOrFail($variation['id']);
                    $variationObj->update([
                        'media_id' => $variation['media_id'],
                        'regular_price' => $variation['regular_price'],
                        'quantity' => $variation['quantity'],
                    ]);
                    foreach ($variation['options'] as $option) {
                        $ids[] = $option['id'];
                        if (isset($option['id']) && $option['id']) {
                            if (!$variationObj->options()->where('option_id', $option['id'])->count()) {
                                $variationObj->options()->create([
                                    'option_id' => $option['id']
                                ]);
                            }
                        }
                    }
                    $variationObj->options()->whereNotIn('option_id', array_filter($ids))->delete();
                }
            }
        }

        if ($variations_to_delete) {
            $product->variations()->whereIn('id', $variations_to_delete)->delete();
        }
    }

    /**
     * Get Product Price.
     * @queryParam options required array
     * @param Product $product
     * @param Request $request
     * @param string $response
     * @return
     */
    public function getVariationPrice(Product $product, Request $request, $response = 'json', $variation = null)
    {
        $variation = $variation ?: $this->getVariation($product, $request->input('options'));
        $price = null;
        if ($variation && $variation->regular_price && $variation->quantity) {
            $price = $variation->regular_price;
        } elseif ($product->is_in_stock) {
            $price = $product->info->price;
        }
        if ($price) {
            if ($response == 'json') {
                return $this->returnCrudData('', null, 'success', [
                    'price' => $price,
                    'cover' => $variation && $variation->media ? $variation->media->getUrl() : ''
                ]);
            }
            return ['price' => $price];
        } else {
            if ($response == 'json') {
                return $this->returnCrudData('This option is out of stock', null, 'error');
            }
            return [];
        }

    }

    private function getVariation(Product $product, $options)
    {
        $variation = $product->variations()->where(function ($query) use ($options) {
            foreach ($options as $option) {
                $query->whereHas('options', function ($query) use ($option) {
                    $query->where('option_id', $option);
                });
            }
        })->latest()->first();
        if (!$variation) {
            $variations = $product->variations()->whereHas('options', function ($query) use ($options) {
                $query->whereIn('option_id', $options);
            })->latest()->get();
            $variation_options = [];
            foreach ($variations as $variationTemp) {
                $item['variation'] = $variationTemp;
                $item['variation_options'] = $variationTemp->options->pluck('option_id')->toArray();
                $item['variation_options_diff'] = array_diff($item['variation_options'], $options);
                $variation_options[] = $item;
            }
            $variation_options = collect($variation_options)->sortBy(function ($item) {
                return sizeof($item['variation_options_diff']);
            });
            $variation = $variation_options->first() ? $variation_options->first()['variation'] : null;
        }
        if (!$variation) {
            $variation = $product->variations()->whereDoesntHave('options')->latest()->first();
        }
        return $variation;
    }
}
