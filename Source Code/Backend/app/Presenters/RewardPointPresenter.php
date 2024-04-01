<?php

namespace App\Presenters;

use App\Models\RewardPoint;
use App\Models\Service;
use Illuminate\Support\Arr;

class RewardPointPresenter extends BasePresenter
{
    public function paginate($models, $sorting_options = [])
    {
        $default = RewardPoint::getSortingOptions()->first();
        $sort_by = $this->getSortBy($default['sort_by']);
        $sort_dir = $this->getSortDir($default['sort_dir']);
        switch ($sort_by) {
            default:
                $models = $models->sortBy($sort_by, SORT_REGULAR, $sort_dir)->values()->all();
                break;
        }

        return $this->helper
            ->paginateArray($models, $this->getPaginationCount())
            ->appends($this->filterQueryStrings());
    }
}
