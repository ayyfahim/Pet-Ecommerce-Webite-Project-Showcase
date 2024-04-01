<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings, ShouldAutoSize
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

        foreach ($this->collection as $key => $product) {
            $category = '';
            $category .= $product->info->parent_category ? $product->info->parent_category->name . '/' : '';
            $category .= $product->info->category ? $product->info->category->name : '';
            $collectionData[$key]['#'] = $key + 1;
            $collectionData[$key]['ID'] = $product->short_id;
            $collectionData[$key]['Name'] = $product->info->title;
            $collectionData[$key]['Category'] = $category;
            $collectionData[$key]['Price'] = $product->price;
            $collectionData[$key]['Brand'] = $product->info->brand ? $product->info->brand->name : '';
            $collectionData[$key]['Supplier'] = $product->vendor ? $product->vendor->company_name : '';
            $collectionData[$key]['Orders (No.)'] = $product->orders_number;
            $collectionData[$key]['Orders ($)'] = "$ " . number_format($product->orders_amount);
            $collectionData[$key]['Upload Date'] = $product->created_at->format('d-m-Y');
            $collectionData[$key]['Last Update'] = $product->updated_at->format('d-m-Y');
            $collectionData[$key]['Last Update By'] = $product->user ? $product->user->full_name : '';
            $collectionData[$key]['Featured'] = $product->features ? 'Yes' : 'No';
            $collectionData[$key]['Stock'] = $product->in_stock_label;
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
            'ID',
            'Name',
            'Category',
            'Price',
            'Brand',
            'Supplier',
            'Orders (No.)',
            'Orders ($)',
            'Upload Date',
            'Last Update',
            'Last Update By',
            'Featured',
            'Stock',
        ];
    }
}
