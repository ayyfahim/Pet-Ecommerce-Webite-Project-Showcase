<?php

namespace App;


use App\Models\Address;

use App\Models\ConfigData;
use App\Models\Role;
use App\Models\Traits\HasRewardPoints;
use App\Notifications\SendNotification;

use Hash;
use App\Models\Cart;
use App\Models\Order;
use App\Models\SocialProvider;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSortings;
use App\Models\Traits\ModelCommon;
use App\Models\Traits\HasCategories;
use App\Models\Traits\HasSoftDeletes;
use App\Models\Traits\HasList;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class User extends Authenticatable implements
    JWTSubject,
    HasMediaContract
{
    use HasSoftDeletes, EntrustUserTrait {
        HasSoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof HasSoftDeletes;
    }
    use Notifiable,
        HasStatus,
        HasSortings,
        HasMedia,
        HasList,
        ModelCommon,
        HasRelationships,
        HasRewardPoints,
        HasCategories;
    public $translatable = ['intro'];
    protected $guarded = ['id', 'password_confirmation'];
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['email_verified_at'];
    protected $casts = [

    ];
    protected static $sorting_options = [4, 2, 3];

    /**
     * fix Entrust package soft delete
     * and laravel soft delete collision.
     *
     * @return [type] [return description]
     */
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    /* ========================================================================== */
    /*                              Override defaults                             */
    /* ========================================================================== */


    /**
     * sendPasswordResetNotification.
     *
     * @param mixed $token
     */
    public function sendPasswordResetNotification($token)
    {
        new SendNotification('forget_password', $this, [
            'user-full-name' => $this->full_name,
            'link' => route('password.reset', [
                'token' => $token,
                'email' => $this->getEmailForPasswordReset(),
            ]),
        ]);
    }

    /**
     * sendEmailVerificationNotification.
     */
    public function sendEmailVerificationNotification()
    {
        new SendNotification('email_verification', $this, [
            'user-full-name' => $this->full_name,
            'link' => $this->verificationUrl(),
        ]);
    }

    protected function verificationUrl()
    {
        return URL::signedRoute(
            'verification.verify',
            ['id' => $this->getKey()]
        );
    }


    /* ========================================================================== */
    /*                                     JWT                                    */
    /* ========================================================================== */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /* ========================================================================== */
    /*                                  ACCESSORS                                 */
    /* ========================================================================== */

    public function getAvatarAttribute()
    {
        return $this->getFirstMedia('avatar');
    }

    public function getFirstNameAttribute()
    {
        $name = explode(' ', $this->full_name);
        return (sizeof($name) > 1 && isset($name[0])) ? $name[0] : $this->full_name;
    }

    public function getIsActiveAttribute()
    {
        return $this->status->order == 1;
    }

    public function getIsVerifiedProviderAttribute()
    {
        return $this->provider_verification_status->order == 2;
    }

    public function getTotalRewardPointsAttribute()
    {
        return (integer)$this->reward_points()->sum('points');
    }

    public function getTotalRewardPointsExchangeAttribute()
    {
        return round($this->total_reward_points * ConfigData::findByType('reward_point_exchange')->value, 0);
    }

    public function getRewardPointsExchangeByPoints($points)
    {
        return isset($points) ? round($points * ConfigData::findByType('reward_point_exchange')->value, 0) : 0;
    }

    /* ------------------------------- get currently active ------------------------------ */


    public function getActiveCartAttribute()
    {
        return $this->carts()->isOpened()->first();
    }

    /* ========================================================================== */
    /*                                  MUTATORS                                  */
    /* ========================================================================== */

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }

    /* ========================================================================== */
    /*                                  RELATIONS                                 */
    /* ========================================================================== */

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function first_latest_address()
    {
        return $this->addresses()->latest()->first();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Cart::class);
    }

    public function basket()
    {
        return $this->carts()->isOpened()->first()->basket();
    }

    public function social_providers()
    {
        return $this->hasMany(SocialProvider::class, 'user_id', 'id');
    }

    /* ========================================================================== */
    /*                                   HELPERS                                  */
    /* ========================================================================== */

    /* --------------------------- verification -------------------------- */

    public function hasCompleteVerification()
    {
        return $this->hasVerifiedEmail();
    }

    /* ------------------------------ roles ----------------------------- */

    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function hasManagerAccess()
    {
        return !$this->hasRole('customer');
    }

    public function attachRoleOf($name)
    {
        return $this->attachRole(Role::where('name', $name)->first());
    }

    /* --------------------------------- others --------------------------------- */
    public function getLastAddressAttribute()
    {
        return $this->addresses()->latest()->first();
    }

}
