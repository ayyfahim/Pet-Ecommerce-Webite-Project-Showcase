<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ReviewRequest;
use Illuminate\Routing\Redirector;

/**
 * @group Review
 */
class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * store
     * @bodyParam product_id required
     * @bodyParam order_id required
     * @bodyParam body required
     * @bodyParam rate required integer
     * @param ReviewRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(ReviewRequest $request)
    {
        try {
            $auth = auth()->user();
            if (!$auth->canReview($request->product_id, $request->order_id)) {
                return $this->returnCrudData("Review Cannot be Added", null, 'error');
            }
            $review = Review::create($request->input());
            return $this->returnCrudData(__('system_messages.common.create_success'), null, 'success', ['id' => $review->id]);
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * update
     * @bodyParam body required
     * @bodyParam rate required integer
     * @param ReviewRequest $request
     * @param Review $review .
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(ReviewRequest $request, Review $review)
    {
        try {
            $this->authorize('update', $review);
            $review->update($request->only(['body', 'rate']));
            return $this->returnCrudData(__('system_messages.common.update_success'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }
}
