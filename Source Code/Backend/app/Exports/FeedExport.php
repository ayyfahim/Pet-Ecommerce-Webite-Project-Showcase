<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeedExport implements FromView, ShouldAutoSize
{
    private $collection;
    private $type;

    public function __construct($collection, $type)
    {
        $this->collection = $collection;
        $this->type = $type;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('pages.products.manager.export', [
            'products' => $this->collection,
            'type' => strtolower($this->type)
        ]);
    }
}
