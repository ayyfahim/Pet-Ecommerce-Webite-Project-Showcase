<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ManagerEventController extends Controller
{
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
        $events = Event::query();

        $events = app(CommonPresenter::class)->paginate($events->get());

        return view('pages.events.manager.index', [
            'events' => $events,
            'breadcrumb' => $this->breadcrumb([], 'News Notifications')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.events.manager.add', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'News Notifications',
                    'route' => route('event.admin.index')
                ]
            ], 'Add News Notification'),
        ]);
    }

    /**
     * store.
     *
     * @param EventRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(EventRequest $request)
    {
        Event::create($request->all());
        return $this->returnCrudData(__('system_messages.common.create_success'), route('event.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $event
     * @return Factory|View
     */
    public function edit(Event $event)
    {
        return view('pages.events.manager.edit', [
            'event' => $event,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'News Notifications',
                    'route' => route('event.admin.index')
                ]
            ], 'Edit News'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $event
     * @param EventRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Event $event, EventRequest $request)
    {
        $event->update($request->except('redirect_to'));
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Event $event
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function destroy(Event $event, Request $request)
    {
        DB::transaction(function () use ($event) {
            $event->user_events()->delete();
            $event->delete();
        });

        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
