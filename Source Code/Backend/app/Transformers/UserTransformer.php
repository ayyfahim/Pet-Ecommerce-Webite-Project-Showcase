<?php

namespace App\Transformers;

use App\User;
use App\Models\Rfp;
use App\Transformers\Traits\HasMap;
use App\Transformers\Traits\HasMedia;
use League\Fractal\Resource\Primitive;
use App\Transformers\Traits\HasReviews;

class UserTransformer extends BaseTransformer
{
    use HasMedia;

    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        $authUser = auth()->user();
        $basicInfo = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'full_name' => $user->full_name,
            'country_code' => $user->country_code,
            'mobile' => $user->mobile,
            'email' => $user->email,
//            'avatar' => $user->avatar ? asset($user->avatar->getUrl()) : '',
            'role' => $user->roles()->latest()->first()->name,
            'status' => [
                'active' => $user->is_active,
                'email_verified' => $user->hasVerifiedEmail(),
            ],
            'addresses' => $this->getDirectData($user->addresses, new AddressTransformer()),
            'total_reward_points' => $user->total_reward_points ?: 0,
            'total_reward_points_exchange' => $user->total_reward_points_exchange ?: 0,
            'created_at' => $user->created_at->toDateString(),
        ];
        return array_merge($basicInfo, []);
    }

    /* -------------------------------- relation -------------------------------- */

    public function includeRelatedRfps(User $user)
    {
        $list = Rfp::query()
            ->whereHas('categories', function ($q) use ($user) {
                $q->whereIn('id', $user->categories->pluck('id'));
            })->latest()
            ->take(config('road9.sysconfig.rfp.user_dashboard_pagination'))
            ->orderBy('categories_count', 'desc')
            ->get();

        return $this->collection($list, new RfpTransformer());
    }

    public function includeCategories(User $user)
    {
        return $this->collection($user->load('categories')->categories, new CategoryTransformer());
    }

    public function includePostedReviews(User $user)
    {
        return $this->getReviews($user->reviews);
    }

    public function includeReceivedReviews(User $user)
    {
        return new Primitive([
            'as_customer' => $this->getReviews($user->getReceivedReviewsAs('customer'), false),
            'as_provider' => $this->getReviews($user->getReceivedReviewsAs('provider'), false),
        ]);
    }

    public function includeBookmarks(User $user)
    {
        return $this->collection($user->load('bookmarks')->bookmarks, new ServiceTransformer());
    }

    public function includeSubscription(User $user)
    {
        return $this->getPrimitive($user->active_package, new SubscriptionTransformer());
    }
}
