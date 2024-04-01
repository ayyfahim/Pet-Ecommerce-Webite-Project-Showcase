<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromView, ShouldAutoSize
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('pages.orders.manager.export',[
            'orders'=>$this->collection
        ]);
    }
}
