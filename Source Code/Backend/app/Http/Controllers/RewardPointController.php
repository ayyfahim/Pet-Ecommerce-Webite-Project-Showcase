<?php

namespace App\Http\Controllers;

use App\Models\RewardPoint;
use App\Http\Controllers\Traits\RewardPoint\Filtration;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RewardPointStore;
use App\Transformers\RewardPointTransformer;
use Illuminate\Routing\Redirector;

class RewardPointController extends Controller
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
        // if (!auth()->check()) {
        //     return $this->returnCrudData('Not authenticated', null, 'error');
        // }
        $rewardpoints = auth()->user()->reward_points()->latest()->get();

        return $this->returnCrudData('', '', 'success', [
            'data' => fractal($rewardpoints, new RewardPointTransformer())->toArray()['data']
        ]);
        // $rewardpoints = RewardPoint::query();
        // if ($this->filterQueryStrings()) {
        //     $rewardpoints = $this->filterData($request, $rewardpoints);
        // }
        // return view('pages.rewardpoints.index',[
        //     'rewardpoints' => app(CommonPresenter::class)->paginate($rewardpoints->get()),
        //     'breadcrumb' => $this->breadcrumb([], 'RewardPoints')
        // ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.rewardpoints.create', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'RewardPoints',
                    'route' => route('rewardpoint.index')
                ]
            ], 'Add New RewardPoint'),

        ]));
    }

    /**
     * store
     *
     * @param RewardPointStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(RewardPointStore $request)
    {
        try {
            RewardPoint::create($request->toArray());
            return $this->returnCrudData(__('system_messages.common.create_success'), route('rewardpoint.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * edit
     *
     * @param RewardPoint $rewardpoint.
     * @return Renderable
     */
    public function edit(RewardPoint $rewardpoint)
    {
        return view('pages.rewardpoints.edit', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'RewardPoints',
                    'route' => route('rewardpoint.index')
                ]
            ], 'Edit RewardPoint'),
            'rewardpoint' => $rewardpoint,
        ]));
    }

    /**
     * update
     *
     * @param RewardPointStore $request
     * @param RewardPoint $rewardpoint.
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(RewardPointStore $request, RewardPoint $rewardpoint)
    {
        try {
           $rewardpoint->update($request->except('redirect_to'));
           return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
        } catch (Exception $exception) {
           return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * show
     *
     * @param RewardPoint $rewardpoint.
     * @return Renderable
     */
    public function show(RewardPoint $rewardpoint)
    {
        if (!auth()->check()) {
            return $this->returnCrudData('Not authenticated', null, 'error');
        }
        return view('pages.rewardpoints.show', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'RewardPoints',
                    'route' => route('rewardpoint.index')
                ]
            ], $rewardpoint->title),
            'rewardpoint' => $rewardpoint
        ]);
    }

    /**
     * destroy
     *
     * @param RewardPoint $rewardpoint.
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(RewardPoint $rewardpoint)
    {
        $rewardpoint->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), route('rewardpoint.index'));
    }

    // Other Methods

    private function commonData()
    {
        return [
            'status' => RewardPoint::getStatusFor('status')
        ];
    }
}
