<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Http\Controllers\Traits\Feed\Filtration;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\FeedRequest;
use Illuminate\Routing\Redirector;

class FeedController extends Controller
{
    use Filtration;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * index
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        $feeds = Feed::query();
        if ($this->filterQueryStrings()) {
            $feeds = $this->filterData($request, $feeds);
        }
        return view('pages.feeds.index',[
            'feeds' => app(CommonPresenter::class)->paginate($feeds->get()),
            'breadcrumb' => $this->breadcrumb([], 'Feeds')
        ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.feeds.create', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Feeds',
                    'route' => route('feed.index')
                ]
            ], 'Add New Feed'),

        ]));
    }

    /**
     * store
     *
     * @param FeedRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(FeedRequest $request)
    {
        try {
            Feed::create($request->toArray());
            return $this->returnCrudData(__('system_messages.common.create_success'), route('feed.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * edit
     *
     * @param Feed $feed.
     * @return Renderable
     */
    public function edit(Feed $feed)
    {
        return view('pages.feeds.edit', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Feeds',
                    'route' => route('feed.index')
                ]
            ], 'Edit Feed'),
            'feed' => $feed,
        ]));
    }

    /**
     * update
     *
     * @param FeedRequest $request
     * @param Feed $feed.
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(FeedRequest $request, Feed $feed)
    {
        try {
           $feed->update($request->except('redirect_to'));
           return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
        } catch (Exception $exception) {
           return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * show
     *
     * @param Feed $feed.
     * @return Renderable
     */
    public function show(Feed $feed)
    {
        return view('pages.feeds.show', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Feeds',
                    'route' => route('feed.index')
                ]
            ], $feed->title),
            'feed' => $feed
        ]);
    }

    /**
     * destroy
     *
     * @param Feed $feed.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Feed $feed)
    {
        $feed->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), route('feed.index'));
    }

    // Other Methods

    private function commonData()
    {
        return [
            'status' => Feed::getStatusFor('status')
        ];
    }
}
