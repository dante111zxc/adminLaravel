<?php

namespace App\Providers;
use App\Policies\AdminPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\MenuPositionPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\ProductCategoryPolicy;
use App\Policies\ProductTagPolicy;
use App\Policies\ReviewsPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\TagPolicy;
use App\Policies\SlidesPolicy;
use App\Policies\ProductAttributesPolicy;
use App\Policies\ProductPolicy;
use App\Policies\MethodPaymentsPolicy;
use App\Policies\OrderPolicy;
use App\Policies\TransactionPcoinPolicy;
use App\Policies\UserPolicy;
use App\Policies\CouponPolicy;
use App\Policies\CouponTemplatePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\Admin' => 'App\Policies\AdminPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Page' => 'App\Policies\PagePolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\Setting' => 'App\Policies\SettingPolicy',
        'App\Models\Tag' => 'App\Policies\TagPolicy',
        'App\Models\MenuPosition' => 'App\Policies\MenuPositionPolicy',
        'App\Models\ProductCategory' => 'App\Policies\ProductCategoryPolicy',
        'App\Models\ProductTag' => 'App\Policies\ProductTagPolicy',
        'App\Models\Slides' => 'App\Policies\SlidesPolicy',
        'App\Models\ProductAttributes' => 'App\Policies\ProductAttributesPolicy',
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\MethodPayments' => 'App\Policies\MethodPaymentsPolicy',
        'App\Models\Orders' => 'App\Policies\OrderPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\TransactionPcoin' => 'App\Policies\TransactionPcoinPolicy',
        'App\Models\Reviews' => 'App\Policies\ReviewsPolicy',
        'App\Models\Coupon' => ' App\Policies\CouponPolicy;',
        'App\Models\CouponTemplate' => ' App\Policies\CouponTemplatePolicy;',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('post.view', PostPolicy::class . '@view');
        Gate::define('post.create', PostPolicy::class . '@create');
        Gate::define('post.edit', PostPolicy::class. '@edit');
        Gate::define('post.delete', PostPolicy::class . '@delete');

        Gate::define('admin.view', AdminPolicy::class . '@view');
        Gate::define('admin.create', AdminPolicy::class . '@create');
        Gate::define('admin.edit', AdminPolicy::class . '@edit');
        Gate::define('admin.delete', AdminPolicy::class . '@delete');


        Gate::define('transactionpcoin.view', TransactionPcoinPolicy::class . '@view');
        Gate::define('transactionpcoin.create', TransactionPcoinPolicy::class . '@create');
        Gate::define('transactionpcoin.edit', TransactionPcoinPolicy::class . '@edit');
        Gate::define('transactionpcoin.delete', TransactionPcoinPolicy::class . '@delete');

        Gate::define('user.view', UserPolicy::class . '@view');
        Gate::define('user.create', UserPolicy::class . '@create');
        Gate::define('user.edit', UserPolicy::class . '@edit');
        Gate::define('user.delete', UserPolicy::class . '@delete');


        Gate::define('category.view', CategoryPolicy::class . '@view');
        Gate::define('category.create', CategoryPolicy::class . '@create');
        Gate::define('category.edit', CategoryPolicy::class . '@edit');
        Gate::define('category.delete', CategoryPolicy::class . '@delete');

        Gate::define('page.view', PagePolicy::class . '@view');
        Gate::define('page.create', PagePolicy::class . '@create');
        Gate::define('page.edit', PagePolicy::class . '@edit');
        Gate::define('page.delete', PagePolicy::class . '@delete');

        Gate::define('role.view', RolePolicy::class . '@view');
        Gate::define('role.create', RolePolicy::class . '@create');
        Gate::define('role.edit', RolePolicy::class . '@edit');
        Gate::define('role.delete', RolePolicy::class . '@delete');

        Gate::define('setting.view', SettingPolicy::class . '@view');
        Gate::define('setting.create', SettingPolicy::class . '@create');
        Gate::define('setting.edit', SettingPolicy::class . '@edit');
        Gate::define('setting.delete', SettingPolicy::class . '@delete');

        Gate::define('tag.view', TagPolicy::class . '@view');
        Gate::define('tag.create', TagPolicy::class . '@create');
        Gate::define('tag.edit', TagPolicy::class . '@edit');
        Gate::define('tag.delete', TagPolicy::class . '@delete');

        Gate::define('menuposition.view', MenuPositionPolicy::class . '@view');
        Gate::define('menuposition.create', MenuPositionPolicy::class . '@create');
        Gate::define('menuposition.edit', MenuPositionPolicy::class . '@edit');
        Gate::define('menuposition.delete', MenuPositionPolicy::class . '@delete');

        Gate::define('product.view', ProductPolicy::class . '@view');
        Gate::define('product.create', ProductPolicy::class . '@create');
        Gate::define('product.edit', ProductPolicy::class . '@edit');
        Gate::define('product.delete', ProductPolicy::class . '@delete');


        Gate::define('product-category.view', ProductCategoryPolicy::class . '@view');
        Gate::define('product-category.create', ProductCategoryPolicy::class . '@create');
        Gate::define('product-category.edit', ProductCategoryPolicy::class . '@edit');
        Gate::define('product-category.delete', ProductCategoryPolicy::class . '@delete');


        Gate::define('product-attributes.view', ProductAttributesPolicy::class . '@view');
        Gate::define('product-attributes.create', ProductAttributesPolicy::class . '@create');
        Gate::define('product-attributes.edit', ProductAttributesPolicy::class . '@edit');
        Gate::define('product-attributes.delete', ProductAttributesPolicy::class . '@delete');

        Gate::define('product-tag.view', ProductTagPolicy::class . '@view');
        Gate::define('product-tag.create', ProductTagPolicy::class . '@create');
        Gate::define('product-tag.edit', ProductTagPolicy::class . '@edit');
        Gate::define('product-tag.delete', ProductTagPolicy::class . '@delete');


        Gate::define('slides.view', SlidesPolicy::class . '@view');
        Gate::define('slides.create', SlidesPolicy::class . '@create');
        Gate::define('slides.edit', SlidesPolicy::class . '@edit');
        Gate::define('slides.delete', SlidesPolicy::class . '@delete');


        Gate::define('methodpayments.view', MethodPaymentsPolicy::class . '@view');
        Gate::define('methodpayments.create', MethodPaymentsPolicy::class . '@create');
        Gate::define('methodpayments.edit', MethodPaymentsPolicy::class . '@edit');
        Gate::define('methodpayments.delete', MethodPaymentsPolicy::class . '@delete');


        Gate::define('order.view', OrderPolicy::class . '@view');
        Gate::define('order.create', OrderPolicy::class . '@create');
        Gate::define('order.edit', OrderPolicy::class . '@edit');
        Gate::define('order.delete', OrderPolicy::class . '@delete');

        Gate::define('reviews.view', ReviewsPolicy::class . '@view');
        Gate::define('reviews.create', ReviewsPolicy::class . '@create');
        Gate::define('reviews.edit', ReviewsPolicy::class . '@edit');
        Gate::define('reviews.delete', ReviewsPolicy::class . '@delete');

        Gate::define('coupon.view', CouponPolicy::class . '@view');
        Gate::define('coupon.create', CouponPolicy::class . '@create');
        Gate::define('coupon.edit', CouponPolicy::class . '@edit');
        Gate::define('coupon.delete', CouponPolicy::class . '@delete');

        Gate::define('coupontemplate.view', CouponTemplatePolicy::class . '@view');
        Gate::define('coupontemplate.create', CouponTemplatePolicy::class . '@create');
        Gate::define('coupontemplate.edit', CouponTemplatePolicy::class . '@edit');
        Gate::define('coupontemplate.delete', CouponTemplatePolicy::class . '@delete');

    }


}
