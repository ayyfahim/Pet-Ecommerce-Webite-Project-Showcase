<?php

namespace App\Models;

use App\Models\Traits\HasReviews;
use App\Models\Traits\HasRewardPoints;
use App\User;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSortings;
use App\Models\Traits\HasProgressTimeline;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Order extends BaseModel
{
    use HasStatus, HasSortings, HasProgressTimeline, HasRewardPoints;

    protected $casts = [
        'amount' => 'decimal:2',
        'is_temp' => 'boolean',
        'mobile' => 'boolean',
        'totals_info' => 'array',
        'payment_info' => 'array',
    ];
    protected static $sorting_options = [4, 14, 15];

    public function scopeToday($query, $column = 'created_at')
    {
        return $query->whereDate($column, Carbon::today()->toDateString());
    }
    /* ========================================================================== */
    /*                                  RELATIONS                                 */
    /* ========================================================================== */
    public function address_info()
    {
        return $this->belongsTo(AddressInfo::class);
    }

    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }

    public function delivery_time()
    {
        return $this->belongsTo(Status::class, 'delivery_time_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(Status::class, 'payment_method_id');
    }

    public function shipping_method()
    {
        return $this->belongsTo(Status::class, 'shipping_method_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function order_notes()
    {
        return $this->hasMany(OrderNote::class);
    }

    public function user()
    {
        return $this->belongsToThrough(User::class, Cart::class);
    }


    /* ========================================================================== */
    /*                                  ACCESSORS                                 */
    /* ========================================================================== */


    /* ========================================================================== */
    /*                                  SCOPES                                 */
    /* ========================================================================== */

    public function scopeIsPersisted($query)
    {
        return $query->where('is_temp', 0);
    }

    /* ========================================================================== */
    /*                                   HELPERS                                  */
    /* ========================================================================== */
    public function getInvoiceNumberAttribute()
    {
        return '#INV' . str_pad($this->number, 6, 0, STR_PAD_LEFT);
    }

    public function getPaymentStatusAttribute()
    {
        $status = "Not Paid";
        if ($this->payment_info && $this->payment_method_id) {
          $status = "Paid";  
        }

        return $status;
    }

    public function getAmountAttribute()
    {
        return $this->totals_info['total'];
    }

    public function getTotalsAttribute()
    {
        $totals = [];
        $total_infos = array_merge(array_flip(['sub_total', 'shipping', 'cod', 'vat', 'discounts', 'total']), $this->totals_info);
        foreach ($total_infos as $key => $value) {
            if (in_array($key, ['discounts', 'shipping'])) {
//            if (in_array($key,['discounts'])) {
                if ($key == 'discounts') {
                    foreach ($value as $discount) {
                        $totals[] = $discount;
                    }
                } else {
                    $totals[] = $value;
                }
                continue;
            }
            if ($value) {
                if ($key == 'cod') {
                    $item['label'] = 'Cash On Delivery Fees';
                } elseif ($key == 'vat') {
                    $item['label'] = 'VAT';
                } else {
                    $item['label'] = ucfirst(str_replace('_', '', $key));
                }
                $item['amount'] = number_format($value, 2);
                $totals[] = $item;
            }
        }
        return $totals;
    }

    public function getProductsQuantityAttribute()
    {
        return $this->cart->basket->sum('quantity');
    }
}
