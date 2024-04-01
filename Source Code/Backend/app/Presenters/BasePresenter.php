<?php

namespace App\Presenters;

use App\Acme\Core;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class BasePresenter
{
    protected $helper;

    public function __construct(Core $helper)
    {
        $this->helper = $helper;
    }

    protected function getPaginationCount()
    {
        return 10;
    }

    /**
     * filter out empty query strings.
     */
    protected function filterQueryStrings()
    {
        return array_filter(request()->query());
    }

    protected function getSortBy($default = null)
    {
        return request('sort_by', $default);
    }

    protected function getSortDir($default = null)
    {
        return request('sort_dir', $default) == 'desc';
    }

}
