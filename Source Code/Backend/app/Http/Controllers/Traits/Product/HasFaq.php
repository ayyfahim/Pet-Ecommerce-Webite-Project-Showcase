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

trait HasFaq
{
    public function addFaq(Request $request)
    {
        return $this->returnCrudData('', null, 'success', [],
            (string)view('pages.products.manager.partials.form-items.faq', [
                'faqKey' => $request->key,
            ]));
    }
    public function addAdditional(Request $request)
    {
        return $this->returnCrudData('', null, 'success', [],
            (string)view('pages.products.manager.partials.form-items.additional', [
                'additionalKey' => $request->key,
            ]));
    }
    public function addSpecification(Request $request)
    {
        return $this->returnCrudData('', null, 'success', [],
            (string)view('pages.products.manager.partials.form-items.specification', [
                'specificationKey' => $request->key,
            ]));
    }
    public function addDosage(Request $request)
    {
        return $this->returnCrudData('', null, 'success', [],
            (string)view('pages.products.manager.partials.form-items.dosage', [
                'dosageKey' => $request->key,
            ]));
    }
    public function addNutritionServing(Request $request)
    {
        return $this->returnCrudData('', null, 'success', [],
            (string)view('pages.products.manager.partials.form-items.nutrition_serving', [
                'nutrition_factServingKey' => $request->key,
            ]));
    }
    public function addNutritionWeight(Request $request)
    {
        return $this->returnCrudData('', null, 'success', [],
            (string)view('pages.products.manager.partials.form-items.nutrition_weight', [
                'nutrition_factWeightKey' => $request->key,
            ]));
    }
    public function addMedia(Request $request)
    {
        return $this->returnCrudData('', null, 'success', [],
            (string)view('pages.products.manager.partials.form-items.media', [
                'mediaKey' => $request->key,
            ]));
    }
}
