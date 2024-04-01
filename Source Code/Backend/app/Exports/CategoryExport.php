<?php

namespace App\Exports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        foreach ($this->collection as $category) {
            $key = 0;
            $collectionData[$key] = $this->setCategory($category,$key);
            $key++;
            foreach ($category->children as $childCategory) {
                $indicator = '-';
                $collectionData[$key] = $this->setCategory($childCategory, $key, $indicator);
                $key++;
                foreach ($category->children as $childChildCategory) {
                    $indicator = '--';
                    $collectionData[$key] = $this->setCategory($childChildCategory, $key, $indicator);
                    $key++;
                }
            }
        }
        return collect($collectionData);
    }

    private function setCategory(Category $category, $key, $indicator = '')
    {
        $data['#'] = $key + 1;
        $data['Category'] = $indicator . $category->name;
        $data['Products'] = $category->products_count;
        $data['Qtty Sold'] = $category->sales_quantity;
        $data['Total Sales'] = "$ " . number_format($category->sales_amount);
        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Category',
            'Products',
            'Qtty Sold',
            'Total Sales',
        ];
    }
}
