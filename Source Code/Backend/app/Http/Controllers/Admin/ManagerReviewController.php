<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Review\Filtration;
use App\Models\Review;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use Illuminate\View\View;

/**
 * @group ManagerReview
 */
class ManagerReviewController extends Controller
{
    use Filtration;

    public function __construct()
    {
    }

    /**
     * index.
     *
     * @queryParam q search in name
     */
    public function index(Request $request)
    {
        $reviews = Review::query();
        if ($this->filterQueryStrings()) {
            $reviews = $this->filterData($request, $reviews);
        }

        $reviews = app(CommonPresenter::class)->paginate($reviews->get());

        return view('pages.reviews.manager.index', [
            'reviews' => $reviews,
            'breadcrumb' => $this->breadcrumb([], 'Reviews')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.reviews.manager.add', [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Reviews',
                    'route' => route('review.admin.index')
                ]
            ], 'Add New Review'),
        ]);
    }

    /**
     * store.
     *
     * @param ReviewRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(ReviewRequest $request)
    {
        Review::create($request->all());
        return $this->returnCrudData(__('system_messages.common.create_success'), route('review.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $review
     * @return Factory|View
     */
    public function edit(Review $review)
    {
        return view('pages.reviews.manager.edit', [
            'review' => $review,
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Reviews',
                    'route' => route('review.admin.index')
                ]
            ], 'Edit Review'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $review
     * @param ReviewRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Review $review, ReviewRequest $request)
    {
        $review->update($request->except('redirect_to'));
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Review $review
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Review $review, Request $request)
    {
        $review->delete();
        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
