<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        foreach ($this->collection as $key => $coupon) {
            $collectionData[$key]['#'] = $key + 1;
            $collectionData[$key]['Name'] = $coupon->title;
            $collectionData[$key]['Code'] = $coupon->code;
            $collectionData[$key]['Value'] = $coupon->discount_amount;
            $collectionData[$key]['Type'] = $coupon->discount_type;
            $collectionData[$key]['Qtty Issued'] = $coupon->uses_per_coupon;
            $collectionData[$key]['Qtty Used'] = $coupon->orders->count();
            $collectionData[$key]['Sales'] = "$ ".number_format($coupon->orders->sum('amount'));
            $collectionData[$key]['Start'] = $coupon->from->format('d-m-Y');
            $collectionData[$key]['End'] = $coupon->to->format('d-m-Y');
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
            'Name',
            'Code',
            'Value',
            'Type',
            'Qtty Issued',
            'Qtty Used',
            'Sales',
            'Start',
            'End',
        ];
    }
}
