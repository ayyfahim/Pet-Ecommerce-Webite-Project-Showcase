<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\RewardPoint\Filtration;
use App\Http\Controllers\Traits\RewardPointFiltration;
use App\Models\RewardPoint;
use App\Presenters\CommonPresenter;
use App\Presenters\RewardPointPresenter;
use App\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Http\Requests\RewardPointStore;
use Illuminate\View\View;

/**
 * @group ManagerRewardPoint
 */
class ManagerRewardPointController extends Controller
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
        $reward_points_users = User::whereHas('reward_points');
        if ($this->filterQueryStrings()) {
            $reward_points_users = $this->filterData($request, $reward_points_users);
        }
        $reward_points_users = app(RewardPointPresenter::class)->paginate($reward_points_users->get(), 'total_reward_points');

        return view('pages.reward_points.manager.index', [
            'rules' => app(RewardPoint::class)->rules,
            'sorting' => RewardPoint::getSortingOptions(),
            'reward_points_users' => $reward_points_users,
            'breadcrumb' => $this->breadcrumb([], 'Reward Points')
        ]);
    }

    /**
     * create.
     * @param null $user_id
     * @return Factory|View
     */
    public function create($user_id = null)
    {
        return view('pages.reward_points.manager.add', array_merge($this->commonData(), [
            'user' => $user_id ? User::find($user_id) : null,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Reward Points',
                    'route' => route('reward_point.admin.index')
                ]
            ], 'Add Reward Points'),
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
            return $this->returnCrudData(__('system_messages.common.create_success'), route('reward_point.admin.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * edit.
     *
     * @param mixed $reward_point
     * @return Factory|View
     */
    public function edit(RewardPoint $reward_point)
    {
        return view('pages.reward_points.manager.edit', array_merge($this->commonData(), [
            'reward_point' => $reward_point,
            'user' => $reward_point->user,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Reward Points',
                    'route' => route('reward_point.admin.index')
                ],
                [
                    'title' => 'Reward Points History',
                    'route' => route('reward_point.admin.show', $reward_point->user->id)
                ]
            ], 'Edit Reward Point'),
        ]));
    }

    /**
     * update.
     *
     * @param mixed $reward_point
     * @param RewardPointStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(RewardPoint $reward_point, RewardPointStore $request)
    {
        $reward_point->update($request->except('redirect_to'));
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * show.
     *
     * @param User $user
     * @return Factory|View
     */
    public function show(User $user)
    {
        return view('pages.reward_points.manager.show', [
            'reward_points' => $user->reward_points()->latest()->get(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Reward Points',
                    'route' => route('reward_point.admin.index')
                ]
            ], 'Reward Points History'),
        ]);
    }

    /**
     * delete.
     *
     * @param RewardPoint $reward_point
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(RewardPoint $reward_point, Request $request)
    {
        $reward_point->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }

    // Other Methods

    private function commonData()
    {
        return [
            'users' => User::withRole('customer')->get()->sortBy('full_name')
        ];
    }
}
