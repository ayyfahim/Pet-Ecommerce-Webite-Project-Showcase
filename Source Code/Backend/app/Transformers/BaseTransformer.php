<?php

namespace App\Transformers;

use App\Acme\Core;
use App\Models\Package;
use App\Models\PackageInfo;
use App\Models\Product;
use App\Models\Service;
use App\Transformers\Traits\HasStatus;
use App\User;
use League\Fractal\Resource\Primitive;
use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    use HasStatus;

    protected function getPrimitive($collection, $transformer)
    {
        return new Primitive($this->getDirectData($collection, $transformer));
    }

    protected function getDirectData($collection, $transformer)
    {
        return fractal($collection, $transformer)->toArray()['data'];
    }

    protected function getUserShort($user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'full_name' => $user->full_name,
//            'avatar' => $user->avatar ? asset($user->avatar->getUrl()) : '',
        ];
    }

    protected function getDate($date)
    {
        $helper = new Core();
        return $date->format('d-m-Y');
        return [
            'original' => $date->toDateTimeString(),
            'formatted_short' => $date->format('d-m-Y'),
            'formatted_long' => $helper->defaultDateFormatter($date)
        ];
    }

    protected function getRate(Product $product)
    {
        $data = [];
        $reviews = $product->reviews;
        $reviews = $reviews->groupBy('rate')->sortKeysDesc();
        for ($i = 5; $i >= 1; $i--) {
            $data[$i] = count($reviews[$i] ?? []);
        }
        return $data;
    }

    public function getTranslatable($model, $attribute)
    {
        return [
            'current' => $model->$attribute,
            'en' => $model->getTranslationWithoutFallback($attribute, 'en'),
            'ar' => $model->getTranslationWithoutFallback($attribute, 'ar'),
        ];
    }

    public function getServiceShort($service, $includeCategories = false)
    {
        $data = [
            'id' => $service->id,
            'slug' => $service->slug,
            'title' => $service->info->title,
            'description' => $service->info->description,
            'location' => $service->info->location,
            'price_per_unit' => $service->info->price_per_unit,
            'overall_rating' => $this->getRate(null, $service, 'service'),
            'unit_type' => $this->getStatus($service->info->unit_type_status),
            'cover' => $service->info->cover ? asset($service->info->cover->getUrl()) : '',
        ];
        if ($includeCategories) {
            $data['categories'] = fractal($service->info->categories, CategoryTransformer::class);
        }
        return $data;
    }

    public function getRfpShort($rfp)
    {
        return [
            'id' => $rfp->id,
            'slug' => $rfp->slug,
            'title' => $rfp->title,
            'description' => $rfp->description,
            'budget_from' => $rfp->budget_from,
            'budget_to' => $rfp->budget_to,
            'show_budget' => $rfp->show_budget,
        ];
    }

    public function getPackage(PackageInfo $packageInfo)
    {
        $limits = $packageInfo->limits;
        foreach ($limits as $key => $limit) {
            $limits[$key] = ['title' => $key, 'count' => $limit];
        }
        return [
            'id' => $packageInfo->package->id,
            'package_info_id' => $packageInfo->package->info->id,
            'slug' => $packageInfo->package->slug,
            'title' => $packageInfo->title,
            'limits' => $limits,
            'duration' => $packageInfo->duration,
            'price' => $packageInfo->price,
            'color' => $packageInfo->color,
            'badge' => $packageInfo->package->badge ? asset($packageInfo->package->badge->getUrl()) : '',
            'showSubscribeButton' => $packageInfo->package->showSubscribeButton()
        ];
    }

    protected function remove_extra_html($text)
    {
        return $text;
        $text = preg_replace("/(font-family: ).*(;)/", '', $text);
        $text = preg_replace("/(color: ).*(;)/", '', $text);
        return $text;
    }

}
