<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Feed\Filtration;
use App\Http\Controllers\Traits\Feed\SyncHelper;
use App\Http\Requests\FeedRequest;
use App\Models\Feed;
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
use Illuminate\Support\Str;
use Illuminate\View\View;

class ManagerFeedController extends Controller
{
    use Filtration, SyncHelper;

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
        $feeds = Feed::query()->whereHas('vendor');
        if ($this->filterQueryStrings()) {
            $feeds = $this->filterData($request, $feeds);
        }
        $feeds = app(CommonPresenter::class)->paginate($feeds->get());

        return view('pages.feeds.index', [
            'vendors' => Vendor::orderBy('company_name')->get(),
            'feeds' => $feeds,
            'breadcrumb' => $this->breadcrumb([], 'Feeds')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.feeds.add', [
            'vendors' => Vendor::orderBy('company_name')->get(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Feeds',
                    'route' => route('feed.admin.index')
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
        return $this->returnCrudData(__('system_messages.common.create_success'), route('feed.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $feed
     * @return Factory|View
     */
    public function edit(Feed $feed)
    {
        $headers = $this->fetch(new Request([
            'url' => $feed->url,
        ]),'json');
        return view('pages.feeds.edit', [
            'feed' => $feed,
            'headers' => $headers,
            'vendors' => Vendor::orderBy('company_name')->get(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Feeds',
                    'route' => route('feed.admin.index')
                ]
            ], 'Edit Feed'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $feed
     * @param FeedRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Feed $feed, FeedRequest $request)
    {
        $data = $request->except('redirect_to');
        if ($request->frequency && $request->frequency != $feed->frequency) {
            $data['next_run_at'] = now()->addHours($request->frequency);
        }
        $feed->update($data);
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Feed $feed
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function destroy(Feed $feed, Request $request)
    {
        DB::transaction(function () use ($feed) {
            $feed->delete();
        });

        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }

    public function fetch(Request $request, $response_type = 'view')
    {
        ini_set('max_execution_time', 1800);
        if (Str::contains($request->url, '.csv')) {
            $fileData = fopen($request->url, 'r');
            $headers = fgetcsv($fileData, 0, ",");
        } elseif (Str::contains($request->url, '.xml')) {
            $xmlString = file_get_contents($request->url);
            $xmlObject = simplexml_load_string($xmlString);
            $json = json_encode($xmlObject);
            $phpArray = json_decode($json, true);
            if (key_exists('@attributes', $phpArray)) {
                unset($phpArray['@attributes']);
            }
            if (!isset($phpArray[array_key_first($phpArray)][array_key_first($phpArray[array_key_first($phpArray)])])) {
                return $this->returnCrudData('XML file is not valid', null, 'error');
            }
            $headers = array_keys($phpArray[array_key_first($phpArray)][array_key_first($phpArray[array_key_first($phpArray)])]);
        }
        if ($response_type == 'json') {
            return $headers;
        }
        return $this->returnCrudData('', null, 'success', [], (string)view('pages.feeds.partials.field', ['headers' => $headers]));
    }

    public function sync(Feed $feed)
    {
        ini_set('max_execution_time', 1800);
        $fields = array_filter($feed->fields);
        $success = $failed = 0;
        if (isset($fields['sku'])) {
            $sku = $fields['sku'];
            if (Str::contains($feed->url, '.csv')) {
                $fileData = fopen($feed->url, 'r');
            } elseif (Str::contains($feed->url, '.xml')) {
                $xmlString = file_get_contents($feed->url);
                $xmlObject = simplexml_load_string($xmlString);
                $json = json_encode($xmlObject);
                $phpArray = json_decode($json, true);
                if (key_exists('@attributes', $phpArray)) {
                    unset($phpArray['@attributes']);
                }
                if (sizeof($phpArray) == 1) {
                    $products = $phpArray[array_key_first($phpArray)];
                    foreach (collect($products)->take(200) as $product) {
                        if (isset($product[$sku]) && $product[$sku]) {
                            try {
                                DB::transaction(function () use ($product, $fields, $sku, $feed, &$success, &$failed) {
                                    $this->sync_product($product[$sku], $product, $fields, $feed);
                                    $success++;
                                });
                            } catch (Exception $exception) {
                                $failed++;
                                continue;
                            }
                        }
                    }
                }
            }
        }
        return $this->returnCrudData("($success) Synced Successfully", route('product.admin.index'));
    }
}
