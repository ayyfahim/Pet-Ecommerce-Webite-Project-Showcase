<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $collectionData = [];
        foreach ($this->collection as $key => $vendor) {
            $collectionData[$key]['#'] = $key + 1;
            $collectionData[$key]['Supplier'] = $vendor->name;
            $collectionData[$key]['Contact Name'] = $vendor->contact_name;
            $collectionData[$key]['Contact Phone'] = $vendor->contact_phone;
            $collectionData[$key]['Contact Email'] = $vendor->email;
            $collectionData[$key]['Products'] = $vendor->products->count();
            $collectionData[$key]['Qtty Sold'] = $vendor->order_products->sum('quantity');
            $collectionData[$key]['Total Sales'] = "$ ".$vendor->order_products->sum('total');
        }
        return collect($collectionData);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Supplier',
            'Contact Name',
            'Contact Phone',
            'Contact Email',
            'Products',
            'Qtty Sold',
            'Total Sales',
        ];
    }
}
