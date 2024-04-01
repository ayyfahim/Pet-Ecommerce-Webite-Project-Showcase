<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FeedExport;
use App\Http\Controllers\Traits\Feed\Filtration;
use App\Http\Requests\FeedRequest;
use App\Models\Category;
use App\Models\Feed;
use App\Models\Product;
use App\Models\SocialFeed;
use App\Models\Vendor;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ManagerSocialFeedController extends Controller
{
    use Filtration;

    public function __construct()
    {
    }

    /**
     * index.
     *
     * @queryParam q search in name
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $social_feeds = Feed::query();
        if ($this->filterQueryStrings()) {
            $social_feeds = $this->filterData($request, $social_feeds);
        }
        $social_feeds = app(CommonPresenter::class)->paginate($social_feeds->get());

        return view('pages.social_feeds.index', [
            'vendors' => Vendor::orderBy('company_name')->get(),
            'social_feeds' => $social_feeds,
            'breadcrumb' => $this->breadcrumb([], 'Feeds')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.social_feeds.add', [
            'vendors' => Vendor::orderBy('company_name')->get(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Feeds',
                    'route' => route('social_feed.admin.index')
                ]
            ], 'Add Feed'),
        ]);
    }

    /**
     * store.
     *
     * @param FeedRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(FeedRequest $request)
    {
        $data = $request->all();
        $data['next_run_at'] = now()->addHours($request->frequency);
        Feed::create($data);
        return $this->returnCrudData(__('system_messages.common.create_success'), route('social_feed.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $social_feed
     * @return Factory|View
     */
    public function edit($social_feed)
    {
        return view('pages.social_feeds.edit', [
            'childCategories' => Category::lastLevel()->get()->groupBy('parent.name')->sortBy('name'),
            'products' => Product::latest()->isActive()->get(),
            'social_feed' => SocialFeed::where('title', $social_feed)->firstOrFail(),
            'breadcrumb' => $this->breadcrumb([
            ], $social_feed . ' Feed'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $social_feed
     * @param FeedRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(SocialFeed $social_feed, FeedRequest $request)
    {
        $data = $request->except('redirect_to');
        if ($request->frequency && $request->frequency != $social_feed->frequency) {
            $data['next_run_at'] = now()->addHours($request->frequency);
        }
        $social_feed->update($data);
        return $this->returnCrudData(__('system_messages.common.update_success'));
    }

    public function export(Request $request, $type)
    {
        $social_feed = SocialFeed::where('title', $type)->first();
        $products = Product::isActive();
        if ($social_feed->excluded_products) {
            $products->whereNotIn('id', $social_feed->excluded_products);
        }
        if ($social_feed->excluded_categories) {
            $products->where(function ($query) use ($social_feed) {
                foreach ($social_feed->excluded_categories as $category) {
                    $query->orWhereJsonDoesntContain('categories_ids', $category);
                }
            });
        }
        $file_name = strtolower($social_feed->title) . "_feed.csv";
        if (Excel::store(new FeedExport($products->get(), $social_feed->title), $file_name)) {
            $social_feed->update([
                'file_name' => asset('storage/' . $file_name),
            ]);
        }
        return $this->returnCrudData('Synced Successfully');
    }
}
