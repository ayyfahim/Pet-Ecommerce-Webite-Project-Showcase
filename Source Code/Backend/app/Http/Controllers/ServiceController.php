<?php

namespace App\Http\Controllers;

use App\Models\Rfp;
use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceInfo;
use App\Transformers\CategoryTransformer;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceStore;
use App\Presenters\ServicePresenter;
use App\Transformers\ServiceTransformer;
use App\Http\Controllers\Traits\Service\Filtration;
use App\Http\Controllers\Traits\Service\ExtendedOps;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\Models\Media;

/**
 * @group Service
 */
class ServiceController extends Controller
{
    use Filtration;
    use ExtendedOps;

    public function __construct()
    {
        $this->middleware('role:provider|admin')->only(['create', 'store', 'edit', 'update']);
        $this->middleware(['auth', 'confirmUserVerification'])->except([
            'index', 'show', 'reviews', 'search'
        ]);
        $this->middleware(['auth', 'canCreateMore:services'])->only(['create', 'store']);
    }

    /**
     * index.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $suggested_services = Service::isSearchable()->whereHas('user', function ($query) {
            $query->whereNull('deleted_at');
        })->isFeatured()->take(10)->get();
        $latest_services = Service::isSearchable()->whereHas('user', function ($query) {
            $query->whereNull('deleted_at');
        })->latest()->take(10)->get();
        $top_categories = Category::whereHas('parent')->wherehas('assigns', function ($query) {
            $query->where('categorisable_type', app(ServiceInfo::class)->full_model_class_name);
        })->withCount('assigns')->orderBy('assigns_count', 'desc')->take(10)->get();
        $top_providers = User::whereNull('deleted_at')->withRole('provider')->get()->where('is_verified_provider', true)->where('is_active', true)->sortByDesc('received_review_rate')->take(6);
        $categories = Category::whereHas('parent')->get()->sortBy('name');
        if ($request->expectsJson()) {
            return response()->json([
                'categories' => fractal($categories, new CategoryTransformer())->toArray(),
                'suggested_services' => fractal($suggested_services, new ServiceTransformer())->toArray(),
                'latest_services' => fractal($latest_services, new ServiceTransformer())->toArray(),
                'top_categories' => fractal($top_categories, new CategoryTransformer())->toArray(),
            ]);
        }
        return view('pages.services.index', [
            'categories' => $categories,
            'suggested_services' => $suggested_services,
            'top_categories' => $top_categories,
            'top_providers' => $top_providers,
        ]);
    }

    /**
     * search.
     *
     * @queryParam title search in title or description
     * @queryParam budget_from
     * @queryParam budget_to
     * @queryParam sub_category_id
     * @queryParam status
     * @queryParam status_id
     * @queryParam publish
     * @queryParam rating
     * @queryParam created_at_range
     * @queryParam location
     * @queryParam lat
     * @queryParam long
     *
     * @queryParam include ['related_services', 'related_rfps', 'gallery', 'partial_reviews', 'reviews']
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $services = Service::query()->with(['user']);
        $services->isSearchable();

        if ($this->filterQueryStrings()) {
            $services = $this->filterServiceData($request, $services);
        } else {
            $services = $services->get();
        }

        $services = app(ServicePresenter::class)->paginate($services);
        $prices['min'] = ServiceInfo::min('price_per_unit');
        $prices['max'] = ServiceInfo::max('price_per_unit');
        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                $services, new ServiceTransformer(), [
                    'sorting' => Service::getSortingOptions(true),
                    'price' => $prices
                ]
            );
        }

        return view('pages.services.index', [
            'services' => $services,
            'sorting' => Service::getSortingOptions(),
            'categories' => Category::with('descendants')->whereIsRoot()->get(),
            'breadcrumb' => $this->breadcrumb([], __("service.services"), 0),
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        if (!auth()->user()->canCreateMore('services')) {
            flash('la m4 hynfa3');
            return redirect()->route('user.provider.subscription');
        }
        $config = config('road9.sysconfig');
        $statusConfig = ServiceInfo::getStatusFor();

        return view('pages.services.add', [
            'categories' => Category::with('descendants')->whereIsRoot()->get(),
            'shipping_methods' => Arr::get($config, 'shipping_methods'),
            'max_gallery_files' => Arr::get($config, 'service.max_gallery_files'),
            'unit_types' => $statusConfig['unit_type'],
            'providers' => User::withRole('provider')->get()->where('is_verified_provider', true),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => __('service.service_manager'),
                    'route' => route('service.manager.index')
                ]
            ], __('service.add_new_service')),
        ]);
    }

    /**
     * store.
     *
     * @param ServiceStore $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     * @bodyParam category_id string required [child only , get from global data]
     * @bodyParam title[en] string required
     * @bodyParam title[ar] string
     * @bodyParam description[en] string required
     * @bodyParam description[ar] string
     * @bodyParam video_url string
     * @bodyParam unit_type_status_id string required
     * @bodyParam delivery_days string required [required if unit type = project]
     * @bodyParam price_per_unit string required
     * @bodyParam min_units string required
     * @bodyParam max_parallel_orders integer required
     * @bodyParam location string
     * @bodyParam lat string
     * @bodyParam long string
     * @bodyParam terms_and_conditions string
     * @bodyParam cover file required
     * @bodyParam gallery file
     */
    public function store(ServiceStore $request)
    {
        if ($request->location && !$request->lat)
            return $this->returnCrudData('Invalid location , please choose from suggestion list', null, 'error');
        $data = $request->except(['category_id', 'cover', 'gallery', 'category', 'user_id']);
        $slug = $request->title['en'];

        DB::transaction(function () use ($request, $slug, $data) {
            $service = Service::create(['user_id' => $request->user_id, 'slug' => $slug]);
            $info = $service->infos()->create($data);

            if ($category = $request->category_id) {
                $info->categories()->sync($category);
            }

            if ($cover = $request->cover) {
                $info->addHashedMedia($cover)->toMediaCollection('cover');
            }

            if ($gallery = $request->gallery) {
                foreach ($gallery as $one) {
                    $info->addHashedMedia($one)->toMediaCollection('gallery');
                }
            }
        });

        return $this->returnCrudData(__('system_messages.common.create_success'), route('service.manager.index'));
    }

    /**
     * show.
     *
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show($slug, Request $request)
    {
        $authUser = auth()->user();
        $service = Service::query();
        $tmpService = Service::findBySlug($slug);
        if (!($authUser && $authUser->id == $tmpService->user_id)) {
            $service->isSearchable();
        }
        $service = $service->findBySlug($slug);
        if (!$service->count())
            abort(404);
        $service->increment('views');
        $related_services = Service::where('id', '!=', $service->id)
            ->whereHas('info.categories', function ($q) use ($service) {
                $q->whereIn('id', $service->info->categories->pluck('id'));
            })
            ->isSearchable()
            ->latest()
            ->take(config('road9.sysconfig.rfp.show_services_pagination'))
            ->get();
        if ($request->expectsJson()) {
            return response()->json([
                'service' => fractal($service, new ServiceTransformer())->parseIncludes(['gallery'])->toArray(),
                'related_services' => fractal($related_services, new ServiceTransformer())->toArray(),
            ]);
        }

        return view('pages.services.show', [
            'service' => $service,
            'slice_limit' => config('road9.sysconfig.reviews.service_show_slice'),
            'related_services' => $related_services,
            'related_rfps' => Rfp::query()
                ->whereHas('categories', function ($q) use ($service) {
                    $q->whereIn('id', $service->info->categories->pluck('id'));
                })
                ->latest()
                ->take(config('road9.sysconfig.rfp.user_dashboard_pagination'))
                ->orderBy('categories_count', 'desc')
                ->get(),

            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => __("service.services"),
                    'route' => route('service.index')
                ]
            ], $service->info->title, 0),
        ]);
    }

    /**
     * edit.
     *
     * @param Service $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Service $id)
    {
        $this->authorize('update', $id);

        $config = config('road9.sysconfig');
        $statusConfig = ServiceInfo::getStatusFor();
        return view('pages.services.edit', [
            'service' => $id,
            'categories' => Category::with('descendants')->whereIsRoot()->get(),
            'shipping_methods' => Arr::get($config, 'shipping_methods'),
            'max_gallery_files' => Arr::get($config, 'service.max_gallery_files'),
            'unit_types' => $statusConfig['unit_type'],
            'providers' => User::withRole('provider')->get()->where('is_verified_provider', true),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => __('service.service_manager'),
                    'route' => route('service.manager.index')
                ]
            ], __('service.edit_service')),
        ]);
    }

    /**
     * update.
     *
     * @param Service $id
     * @param ServiceStore $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @bodyParam category_id string [child only , get from global data]
     * @bodyParam title[en] string
     * @bodyParam title[ar] string
     * @bodyParam description[en] string
     * @bodyParam description[ar] string
     * @bodyParam video_url string
     * @bodyParam unit_type_status_id [get from global data]
     * @bodyParam max_parallel_orders integer
     * @bodyParam delivery_days string  [if unit type = project]
     * @bodyParam price_per_unit string
     * @bodyParam min_units string
     * @bodyParam location string
     * @bodyParam lat string
     * @bodyParam long string
     * @bodyParam terms_and_conditions string
     * @bodyParam status_id string [get from global data]
     * @bodyParam publish_status_id string [get from global data]
     * @bodyParam publish_status_id string [get from global data]
     * @bodyParam cover file
     * @bodyParam gallery file
     * @bodyParam media_to_delete array [array of ids]
     */
    public function update(Service $id, ServiceStore $request)
    {
        $this->authorize('update', $id);
        if ($request->location && !$request->lat)
            return $this->returnCrudData('Invalid location , please choose from suggestion list', null, 'error');
        if ($request->gallery) {
            $curr = $id->info->gallery->count() + sizeof($request->gallery);
            $max = config('road9.sysconfig.service.max_gallery_files');
            if (($max - $curr) < 0) {
                return $this->returnCrudData("You've exceed the max gallery images for this service", null, 'error');
            }
        }
//        $this->hydrateCheckboxs(ServiceInfo::class, $request);

        $data = $request->except(['category_id', 'cover', 'gallery', 'category', 'user_id', 'media_to_delete']);
        if ($request->title && isset($request->title['en']) && $id->wasChanged('title')) {
            $slug = $request->title['en'];
            $id->update(['slug' => $slug]);
        }
        if ($request->user_id) {
            $id->update(['user_id' => $request->user_id]);
        }
        $id->info->update($data);
        $info = $id->info;

        if ($category = $request->category_id) {
            $info->categories()->sync($category);
        }

        if ($cover = $request->cover) {
            $info->addHashedMedia($cover)->toMediaCollection('cover');
        }
        if ($gallery = $request->gallery) {
            foreach ($gallery as $one) {
                $info->addHashedMedia($one)->toMediaCollection('gallery');
            }
        }
        if ($media_to_delete = $request->media_to_delete) {
            foreach ($media_to_delete as $media_id) {
                if ($media = Media::find($media_id)) {
                    $media->delete();
                }
            }
        }

        return $this->returnCrudData(__('system_messages.common.update_success'), route('service.manager.index'));
    }

    /**
     * delete.
     *
     * @param Service $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Service $id)
    {
        $this->authorize('delete', $id);

        $id->delete();

        return $this->returnCrudData(__('system_messages.common.delete_success'), url()->previous());
    }
}
