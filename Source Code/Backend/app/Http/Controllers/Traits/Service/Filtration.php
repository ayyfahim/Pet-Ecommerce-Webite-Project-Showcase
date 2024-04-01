<?php

namespace App\Http\Controllers\Traits\Service;

use App\Http\Controllers\Traits\HasResets;
use Carbon\Carbon;

trait Filtration
{
    use HasResets;

    /**
     * Service.
     *
     * @param mixed $request
     * @param mixed $collection
     */
    protected function filterServiceData($request, $collection)
    {
        $this->resetFilterFor($request, [
            'sector',
        ]);

        $title = $request->q = $request->title;
        $budget_from = $request->budget_from;
        $budget_to = $request->budget_to;
        $category_id = $request->sub_category_id;
        $category = $request->sub_category;
        $status = $request->status;
        $status_id = $request->status_id;
        $publish = $request->publish;
        $rate = $request->rating;
        $created_at_range = $request->created_at_range ? explode('--', $request->created_at_range) : null;
        $created_at_from = $created_at_range ? Carbon::parse($created_at_range[0])->toDateString() : null;
        $created_at_to = $created_at_range ? Carbon::parse($created_at_range[1])->toDateString() : null;
        $lat = $request->location ? $request->lat : null;
        $long = $request->location ? $request->long : null;
        $collection->when($title, function ($query) use ($title) {
            return $query->whereHas('info', function ($query) use ($title) {
                $query->where(function ($query) use ($title) {
                    $query->where('title->en', 'like', '%' . $title . '%');
                    $query->orWhere('title->ar', 'like', '%' . $title . '%');
                    $query->orWhere('description->en', 'like', '%' . $title . '%');
                    $query->orWhere('description->ar', 'like', '%' . $title . '%');
                });
            })->orWhereHas('user', function ($query) use ($title) {
                $query->whereRaw('concat(first_name, " ", last_name) like ?', ['%' . $title . '%']);
            });
        })->when($budget_from, function ($query) use ($budget_from) {
            return $query->whereHas('info', function ($i) use ($budget_from) {
                $i->where('price_per_unit', '>=', $budget_from);
            });
        })->when($budget_to, function ($query) use ($budget_to) {
            return $query->whereHas('info', function ($i) use ($budget_to) {
                $i->where('price_per_unit', '<=', $budget_to);
            });
        })->when($category_id, function ($query) use ($category_id) {
            return $query->whereHas('info', function ($query) use ($category_id) {
                $query->whereHas('categories', function ($query) use ($category_id) {
                    $query->where('id', $category_id);
                });
            });
        })->when($category, function ($query) use ($category) {
            return $query->whereHas('info', function ($query) use ($category) {
                $query->whereHas('categories', function ($query) use ($category) {
                    $query->where('name->' . $this->getCurrentLocale(), 'like', '%' . $category . '%');
                });
            });
        })->when($lat && $long, function ($query) use ($lat, $long) {
            return $query->whereHas('info', function ($i) use ($lat, $long) {
                $i->geofence($lat, $long, 0, config('road9.sysconfig.service.geofence_max_distance'));
            });
        })->
        when($status, function ($query) use ($status) {
            return $query->whereHas('info.status', function ($s) use ($status) {
                $s->where('title->' . $this->getCurrentLocale(), $status);
            });
        })->when($status_id, function ($query) use ($status_id) {
            return $query->whereHas('info.status', function ($s) use ($status_id) {
                $s->where('id', $status_id);
            });
        })->when($publish, function ($query) use ($publish) {
            return $query->whereHas('info.publish_status', function ($s) use ($publish) {
                $s->where('title->' . $this->getCurrentLocale(), $publish);
            });
        })->when($created_at_from, function ($query) use ($created_at_from) {
            return $query->whereDate('created_at', '>=', Carbon::parse($created_at_from)->toDateString());
        })->when($created_at_to, function ($query) use ($created_at_to) {
            return $query->whereDate('created_at', '<=', Carbon::parse($created_at_to)->toDateString());
        });
        $collection = $collection->get();
        if ($rate) {
            $collection = $collection->where('received_reviews_rate', '>=', $rate);
        }
        return $collection;
    }

    /**
     * ServiceRequest.
     *
     * @param mixed $request
     * @param mixed $collection
     */
    protected
    function filterServiceRequestData($request, $collection)
    {
        $title = $request->q;
        $status = $request->status;
        $status_id = $request->status_id;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $delivery_days = $request->delivery_days;
        $collection->when($title, function ($query) use ($title) {
            return $query->whereHas('info', function ($query) use ($title) {
                $query->where(function ($query) use ($title) {
                    $query->where('title->en', 'like', '%' . $title . '%');
                    $query->orWhere('title->ar', 'like', '%' . $title . '%');
                });
            });
        })->when($status, function ($query) use ($status) {
            return $query->whereHas('status', function ($s) use ($status) {
                $s->where('title->' . $this->getCurrentLocale(), $status);
            });
        })->when($date_from, function ($query) use ($date_from) {
            return $query->whereDate('created_at', '>=', Carbon::parse($date_from)->toDateString());
        })->when($date_to, function ($query) use ($date_to) {
            return $query->whereDate('created_at', '<=', Carbon::parse($date_to)->toDateString());
        })->when($status_id, function ($query) use ($status_id) {
            $query->where('status_id', $status_id);
        });
        $collection = $collection->get();
        if ($delivery_days) {
            $collection = $collection->where('delivery_days', $delivery_days);
        }

        return $collection;
    }
}
