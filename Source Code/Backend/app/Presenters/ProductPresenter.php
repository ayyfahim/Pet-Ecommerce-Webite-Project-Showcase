<?php

namespace App\Presenters;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Arr;

class ProductPresenter extends BasePresenter
{
    public function paginate($models, $sorting_options = [])
    {
        $default = Product::getSortingOptions(false, $sorting_options)->first();
        $sort_by = $this->getSortBy($default['sort_by']);
        $sort_dir = $this->getSortDir($default['sort_dir']);

        switch ($sort_by) {
            default:
                if ($sorting_options) {
                    $models = $models->sortBy($sort_by, SORT_REGULAR, $sort_dir)->values()->all();
                } else {
                    $models = $models->sortBy("info.$sort_by", SORT_REGULAR, $sort_dir)->values()->all();
                }
                break;
        }

        return $this->helper
            ->paginateArray($models, $this->getPaginationCount())
            ->appends($this->filterQueryStrings());
    }
}
