<?php

namespace App\Http\Controllers\Traits\Service;

use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceInfo;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Presenters\ServicePresenter;
use App\Transformers\ServiceTransformer;

trait ExtendedOps
{
    /**
     * Service Manager.
     *
     * @authenticated
     * @queryParam q search in title or description
     * @queryParam category_id
     * @queryParam status_id
     * @queryParam publish
     * @queryParam created_at_range
     */
    public function manager(Request $request)
    {
        $user = auth()->user();
        $config = ServiceInfo::getstatusFor();
        $services = $user->isAdmin() ? Service::query() : $user->services();

        if ($this->filterQueryStrings()) {
            $services = $this->filterServiceData($request, $services);
        } else {
            $services = $services->get();
        }
        $services = app(ServicePresenter::class)->paginate($services);
        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                $services, new ServiceTransformer(), ['sorting' => Service::getSortingOptions(true)], ['gallery']
            );
        }

        return view('pages.services.manager.index', [
            'services' => $services,
            'sorting' => Service::getSortingOptions(),
            'categories' => Category::with('descendants')->whereIsRoot()->get(),
            'config' => [
                'status' => $config['status'],
                'publish' => $config['publish'],
            ],
            'breadcrumb' => $this->breadcrumb([], __("service.service_manager")),
        ]);
    }

    /**
     * reviews.
     *
     * @param \App\Models\Service $id
     * @param \Illuminate\Http\Request $request
     */
    public function reviews($slug, Request $request)
    {
        $authUser = auth()->user();
        $service = Service::query();
        $tmpService = Service::findBySlug($slug);
        if (!($authUser && $authUser->id == $tmpService->user_id)) {
            $service->isSearchable();
        }
        $service = $service->with(['reviews', 'info.categories.parent'])->findBySlug($slug);
        if ($request->expectsJson()) {
            return fractal($service, new ServiceTransformer())
                ->parseIncludes(['reviews'])
                ->respond();
        }

        return view('pages.services.reviews.list', [
            'service' => $service,
            'sorting' => Review::getSortingOptions(),
            'breadcrumb' => $this->breadcrumb([], __("review.reviews")),
        ]);
    }
}
