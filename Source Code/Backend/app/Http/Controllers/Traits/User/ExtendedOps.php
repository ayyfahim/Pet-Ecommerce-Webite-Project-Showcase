<?php

namespace App\Http\Controllers\Traits\User;

use App\User;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Presenters\UserPresenter;
use App\Presenters\ReviewPresenter;
use App\Transformers\UserTransformer;
use App\Transformers\ReviewTransformer;
use App\Transformers\ServiceTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Zizaco\Entrust\EntrustRole as Role;

trait ExtendedOps
{
    use Filtration;

    /**
     * manager index.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @queryParam q search in first_name, last_name or category
     */
    public function manager(Request $request)
    {
        $users = User::query();
        $config = User::getStatusFor();

        if ($this->filterQueryStrings()) {
            $users = $this->filterData($request, $users);
        }

        return view('pages.user.manager.index', [
            'users' => app(UserPresenter::class)->paginate($users->get()),
            'sorting' => User::getSortingOptions(),
            'roles' => Role::get(),
            'provider_verification_id' => $config['provider_verification']->firstWhere('order', 2)->id,
            'status' => $config['status'],
            'verification_status' => $config['provider_verification'],
            'breadcrumb' => $this->breadcrumb([], 'Users Manager')
        ]);
    }

    /**
     * bookmarks.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function bookmarks(Request $request)
    {
        $bks = auth()->user()->bookmarks;

        if ($request->expectsJson()) {
            return fractal($bks, new ServiceTransformer())->respond();
        }

        return view('pages.user.profile.bookmarks', [
            'bookmarks' => $bks,
        ]);
    }

    /**
     * reviews.
     * @param User $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function reviews(User $id, Request $request)
    {
        if ($request->expectsJson()) {
            $as_customer = app(ReviewPresenter::class)->paginate($id->getReceivedReviewsAs('customer'));
            $as_provider = app(ReviewPresenter::class)->paginate($id->getReceivedReviewsAs('provider'));
            return response()->json([
                'as_customer' => fractal($as_customer->getCollection(), new ReviewTransformer())
                    ->paginateWith(new IlluminatePaginatorAdapter($as_customer))
                    ->toArray(),
                'as_provider' => fractal($as_provider->getCollection(), new ReviewTransformer())
                    ->paginateWith(new IlluminatePaginatorAdapter($as_provider))
                    ->toArray(),
            ]);
        }

        return view('pages.reviews.customer', [
            'user' => $id,
            'sorting' => Review::getSortingOptions(),
        ]);
    }

    /**
     * posted reviews.
     *
     * @queryParam include ['owner', 'receiver', 'order']
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postedReviews(Request $request)
    {
        $user = auth()->user();

        if ($this->filterQueryStrings()) {
            $user = $this->filterReviewsData($request, $user);
        }

        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                app(ReviewPresenter::class)->paginate($user->reviews),
                new ReviewTransformer(),
                ['sorting' => Review::getSortingOptions(true)]
            );
        }

        return view('pages.reviews.posted', [
            'user' => $user,
            'sorting' => Review::getSortingOptions(),
        ]);
    }
}
