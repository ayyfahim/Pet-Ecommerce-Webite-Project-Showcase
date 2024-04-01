<?php

namespace App\Acme;

use App\Models\HomeConfig;
use App\Models\Page;
use App\Models\SupportConfig;
use Carbon\Carbon;
use URL;
use Blade;
use Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Core
{
    /**
     * [caching description].
     *
     * @return [type] [description]
     */
    public function caching()
    {
    }

    /**
     * custome facade functions.
     *
     * @return [type] [description]
     */
    public function macros()
    {
        $this->blade();
        $this->route();
        $this->url();
        $this->eloquent();
        $this->validation();
        // https://dotdev.co/use-laravel-validator-while-filtering-collections-e4e753d40b99#.amd9rkjgz
        // https://adamwathan.me/2016/04/06/cleaning-up-form-input-with-transpose/
    }

    protected function eloquent()
    {
        // https://laracasts.com/discuss/channels/eloquent/pluck-from-a-nested-collection?page=1#reply=447477
        Collection::macro('pluckSubRelation', function ($field) {
            $arr = explode('.', $field);
            $toGet = array_pop($arr);

            $res = $this;
            foreach ($arr as $relation) {
                $res = $res->pluck($relation)->flatten();
            }

            return $res->pluck($toGet);
        });

        // https://scotch.io/tutorials/understanding-and-using-laravel-eloquent-macros#toc-a-quick-example
        HasMany::macro('toHasOne', function () {
            return new HasOne(
                $this->getQuery(),
                $this->getParent(),
                $this->foreignKey,
                $this->localKey
            );
        });
    }

    protected function blade()
    {
        Blade::directive('dd', function ($param) {
            return "<?php dd($param); ?>";
        });

        Blade::if('dev', function () {
            return app()->environment('local');
        });
    }

    protected function route()
    {
        // https://laracasts.com/discuss/channels/laravel/setting-route-namespace-to-outside-the-apphttpcontroller-directorynamespace/replies/432789
        Route::macro('setGroupNamespace', function ($namesapce = null) {
            // Get last groupStack data and hard change the namespace value
            $lastGroupStack = array_pop($this->groupStack);

            if ($lastGroupStack !== null) {
                Arr::set($lastGroupStack, 'namespace', $namesapce);
                $this->groupStack[] = $lastGroupStack;
            }

            return $this;
        });
    }

    protected function url()
    {
        // same as "Route::is()" but better
        URL::macro('is', function ($route_name, $params = null) {
            return $params
                ? request()->url() == route($route_name, $params)
                : request()->url() == route($route_name);
        });

        URL::macro('has', function ($needle) {
            return Str::contains($this->current(), $needle);
        });
    }

    protected function validation()
    {
    }

    /**
     * share date across all views.
     *
     * @return [type] [description]
     */
    public function viewShares()
    {
        view()->share('helper', $this);
        view()->share('avatarDef', asset(config('road9.sysconfig.default-avatar')));
        view()->share('adminAvatarDef', asset(config('road9.sysconfig.default-admin-avatar')));
    }

    /**
     * viewComposers.
     */
    public function viewComposers()
    {
        view()->composer('*', function ($view) {
            $view->with([
                'authUser' => auth()->user(),
            ]);
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                                   helpers                                  */
    /* -------------------------------------------------------------------------- */

    /**
     * getCurrencyNameFor.
     *
     * @param mixed $country
     * @param mixed $type
     */
    public function getCurrencyNameFor($country, $type = 'short')
    {
        $cur = collect(country($country)->getCurrency());

        return $type == 'short' ? $cur['iso_4217_code'] : $cur['iso_4217_name'];
    }

    /**
     * currency.
     *
     * @param mixed $money
     * @param mixed $decimals
     * @param mixed $decimalpoint
     * @param mixed $separator
     * @param mixed '
     */
    public function currency($money, $decimals = 0, $decimalpoint = '.', $separator = ',')
    {
        return number_format($money, $decimals, $decimalpoint, $separator);
    }

    /**
     * addToCurrentQS.
     *
     * @param mixed $arr
     */
    public function addToCurrentQS($arr)
    {
        return request()->fullUrlWithQuery(array_merge(request()->query(), $arr));
    }

    /**
     * paginate array or collection.
     *
     * @param array|Collection $items
     * @param int $perPage
     * @param int $page
     *
     * @return LengthAwarePaginator
     */
    public function paginateArray($items, $perPage = 15, $page = null)
    {
        $pageName = 'page';
        $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }

    public function get_dashboard_menu_items()
    {
        $request = request();
        $user = auth()->user();
        return collect([
            [
                'type' => 'menu_item',
                'label' => 'Dashboard',
                'is_active' => $request->is('*admin'),
                'route' => route('admin.dashboard'),
                'has_permission' => $user->can('view_dashboard'),
                'icon' => 'home',
                'children' => [],
            ],
            [
                'type' => 'header',
                'label' => 'Catalog',
                'has_permission' => $user->can('view_products') || $user->can('view_categories') || $user->can('view_brands')
                    || $user->can('view_icons') || $user->can('view_attributes'),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Products',
                'route' => route('product.admin.index'),
                'icon' => 'codesandbox',
                'is_active' => $request->is('*admin/products'),
                'has_permission' => $user->can('view_products'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Categories', 'route' => route('category.admin.index'),
                'icon' => 'align-left',
                'is_active' => $request->is('*admin/categories*'),
                'has_permission' => $user->can('view_categories'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Brands',
                'route' => route('brand.admin.index'),
                'icon' => 'book',
                'is_active' => $request->is('*admin/brands*'),
                'has_permission' => $user->can('view_brands'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Concerns',
                'route' => route('concern.admin.index'),
                'icon' => 'book',
                'is_active' => $request->is('*admin/concerns*'),
                'has_permission' => $user->can('view_brands'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Breeds',
                'route' => route('breed.admin.index'),
                'icon' => 'book',
                'is_active' => $request->is('*admin/breeds*'),
                'has_permission' => $user->can('view_brands'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Pet Type',
                'route' => route('petType.admin.index'),
                'icon' => 'book',
                'is_active' => $request->is('*admin/pet_types*'),
                'has_permission' => $user->can('view_brands'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Attributes',
                'route' => route('attribute.admin.index'),
                'icon' => 'archive',
                'is_active' => $request->is('*admin/attributes*'),
                'has_permission' => $user->can('view_attributes'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Suppliers',
                'route' => route('vendor.admin.index'),
                'icon' => 'shopping-bag',
                'is_active' => $request->is('*admin/suppliers*'),
                'has_permission' => $user->can('view_vendors'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Icons',
                'route' => route('icon.admin.index'),
                'icon' => 'check-circle',
                'is_active' => $request->is('*admin/icons*'),
                'has_permission' => $user->can('view_icons'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Import Products',
                'route' => route('product.admin.import'),
                'icon' => 'codesandbox',
                'is_active' => $request->is('*admin/products/import*'),
                'has_permission' => $user->can('add_products'),
                'children' => collect([]),
            ],
            [
                'type' => 'header',
                'label' => 'Sales',
                'has_permission' => $user->can('view_coupons') || $user->can('view_orders') || $user->can('view_reward_points'),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Orders',
                'route' => route('order.admin.index'),
                'icon' => 'shopping-cart',
                'is_active' => $request->is('*admin/orders*'),
                'has_permission' => $user->can('view_orders'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Courriers',
                'route' => route('courrier.admin.index'),
                'icon' => 'shopping-cart',
                'is_active' => $request->is('*admin/courriers*'),
                'has_permission' => $user->can('view_orders'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Discount Coupons',
                'route' => route('coupon.admin.index'),
                'icon' => 'tag',
                'is_active' => $request->is('*admin/coupons*'),
                'has_permission' => $user->can('view_coupons'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Reward Points',
                'route' => route('reward_point.admin.index'),
                'icon' => 'award',
                'is_active' => $request->is('*admin/reward_points*'),
                'has_permission' => $user->can('view_reward_points'),
                'children' => collect([]),
            ],
            [
                'type' => 'header',
                'label' => 'Users',
                'has_permission' => $user->can('view_customers') || $user->can('view_admins') || $user->can('view_roles'),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Customers',
                'route' => route('user.admin.index'),
                'icon' => 'users',
                'is_active' => $request->is('*admin/customers*'),
                'has_permission' => $user->can('view_customers'),
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Management',
                'route' => '#',
                'icon' => 'shield',
                'is_active' => $request->is('*admin/management*'),
                'has_permission' => $user->can('view_admins') || $user->can('view_roles'),
                'children' => collect([
                    [
                        'label' => 'Users',
                        'route' => route('management.admin.user.index'),
                        'is_active' => $request->is('*admin/management/users*'),
                        'has_permission' => $user->can('view_admins'),
                    ],
                    [
                        'label' => 'Roles',
                        'route' => route('management.admin.role.index'),
                        'is_active' => $request->is('*admin/management/roles*'),
                        'has_permission' => $user->can('view_roles'),
                    ],
                ]),
            ],
            
            [
                'type' => 'header',
                'label' => 'Content',
                'has_permission' => $user->can('view_email_templates') || $user->can('view_pages'),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Content',
                'icon' => 'file-text',
                'route' => '#',
                'is_active' => $request->is('*admin/content*'),
                'has_permission' => $user->can('view_email_templates') || $user->can('view_pages'),
                'children' => collect([
                    [
                        'label' => 'Email Templates',
                        'route' => route('content.admin.email_template.index'),
                        'is_active' => $request->is('*admin/content/email_templates*'),
                        'has_permission' => $user->can('view_email_templates'),
                    ],
                    [
                        'label' => 'Pages',
                        'route' => route('content.admin.page.index'),
                        'is_active' => $request->is('*admin/content/pages*'),
                        'has_permission' => $user->can('view_pages'),
                    ],
                    [
                        'label' => 'FAQ',
                        'route' => route('question.admin.index'),
                        'is_active' => $request->is('*admin/content/faq*'),
                        'has_permission' => $user->can('view_pages'),
                    ],
                    // [
                    //     'label' => 'Blog',
                    //     'route' => route('article.admin.index'),
                    //     'is_active' => $request->is('*admin/articles*'),
                    //     'has_permission' => $user->can('view_pages'),
                    // ],
                ]),
            ],

            // [
            //     'type' => 'header',
            //     'label' => 'Frontend',
            //     'has_permission' => $user->can('view_pages'),
            // ],

            // [
            //     'type' => 'menu_item',
            //     'label' => 'Pages',
            //     'icon' => 'file-text',
            //     'route' => '#',
            //     'is_active' => $request->is('*admin/frontend*'),
            //     'has_permission' => $user->can('view_pages'),
            //     'children' => collect([
            //         [
            //             'label' => 'Home Page',
            //             'route' => route('frontend.admin.page.homepage'),
            //             'is_active' => $request->is('*admin/frontend/pages/homepage*'),
            //             'has_permission' => $user->can('view_pages'),
            //         ],
            //         [
            //             'label' => 'Reward Program Page',
            //             'route' => route('frontend.admin.page.reward_program'),
            //             'is_active' => $request->is('*admin/frontend/pages/reward_program*'),
            //             'has_permission' => $user->can('view_pages'),
            //         ],
            //         [
            //             'label' => 'About Us Page',
            //             'route' => route('frontend.admin.page.about_us'),
            //             'is_active' => $request->is('*admin/frontend/pages/about_us*'),
            //             'has_permission' => $user->can('view_pages'),
            //         ],
            //     ]),
            // ],

            [
                'type' => 'header',
                'label' => 'Blog',
                'has_permission' => $user->can('view_pages'),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Article',
                'route' => route('article.admin.index'),
                'is_active' => $request->is('*admin/articles*'),
                'has_permission' => $user->can('view_pages'),
                'icon' => 'bookmark',
            ],
            [
                'type' => 'menu_item',
                'label' => 'Authors',
                'route' => route('author.admin.index'),
                'is_active' => $request->is('*admin/authors*'),
                'has_permission' => $user->can('view_pages'),
                'icon' => 'user',
            ],

            [
                'type' => 'header',
                'label' => 'Settings',
                'has_permission' => $user->can('view_configurations'),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Facebook Feed',
                'route' => route('social_feed.admin.edit', 'Facebook'),
                'icon' => 'rss',
                'is_active' => $request->is('*Facebook*'),
                'has_permission' => true,
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Google Feed',
                'route' => route('social_feed.admin.edit', 'Google'),
                'icon' => 'rss',
                'is_active' => $request->is('*Google*'),
                'has_permission' => true,
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Suppliers Feed',
                'route' => route('feed.admin.index'),
                'icon' => 'rss',
                'is_active' => $request->is('*admin/feeds*'),
                'has_permission' => true,
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Redirections',
                'route' => route('redirection.admin.index'),
                'icon' => 'refresh-ccw',
                'is_active' => $request->is('*admin/redirections*'),
                'has_permission' => true,
                'children' => collect([]),
            ],
            [
                'type' => 'menu_item',
                'label' => 'Configuration',
                'is_active' => request()->is('*config*'),
                'has_permission' => $user->can('view_configurations'),
                'route' => '#',
                'icon' => 'settings',
                'children' => [
                    [
                        'label' => 'Site Settings',
                        'is_active' => request()->is('*site_settings*'),
                        'route' => route('config.manager.index', 'site_settings'),
                        'has_permission' => $user->can('view_configurations'),
                    ],
                    [
                        'label' => 'Contact Info',
                        'is_active' => request()->is('*contact*'),
                        'route' => route('config.manager.index', 'contact'),
                        'has_permission' => $user->can('view_configurations'),
                    ],
                    [
                        'label' => 'Social Media',
                        'is_active' => request()->is('*social_media*'),
                        'route' => route('config.manager.index', 'social_media'),
                        'has_permission' => $user->can('view_configurations'),
                    ],
                    [
                        'label' => 'Checkout',
                        'is_active' => request()->is('*checkout*'),
                        'route' => route('config.manager.index', 'checkout'),
                        'has_permission' => $user->can('view_configurations'),
                    ],
                    [
                        'label' => 'SEO',
                        'is_active' => request()->is('*seo*'),
                        'route' => route('config.manager.index', 'seo'),
                        'has_permission' => $user->can('view_configurations'),
                    ],
                    [
                        'label' => 'Integrations',
                        'is_active' => request()->is('*integration*'),
                        'route' => route('config.manager.index', 'integration'),
                        'has_permission' => $user->can('view_configurations'),
                    ],
                    [
                        'label' => 'Coupons',
                        'is_active' => request()->is('*coupon*'),
                        'route' => route('config.manager.index', 'coupon'),
                        'has_permission' => $user->can('view_configurations'),
                    ],
                ],
            ],
        ])->where('has_permission');
    }

    public function pagination_label($collection, $label = 'Entities')
    {
        $start = ($collection->currentpage() - 1) * $collection->perpage() + 1;
        $end = (($collection->currentpage() - 1) * $collection->perpage()) + $collection->count();
        $total = $collection->total();
        return 'Showing ' . $start . ' - ' . $end . ' of ' . $total . ' ' . $label;
    }
}
