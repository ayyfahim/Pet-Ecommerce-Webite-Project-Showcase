<?php


namespace App\Http\Controllers\Traits\Product;


use App\Models\Country;
use Illuminate\Http\Request;

trait HasVoucher
{
    public function getCountries(Request $request)
    {
        if ($request->region) {
            return $this->returnCrudData('', null, 'success',
                Country::select('id', 'region', 'name')
                    ->where('region', $request->region)
                    ->get());
        }
    }

    public function getCities(Request $request)
    {
        if ($request->country_id) {
            return $this->returnCrudData('', null, 'success',
                Country::findOrFail($request->country_id)->cities()->select('name')->get());
        }
    }
}
