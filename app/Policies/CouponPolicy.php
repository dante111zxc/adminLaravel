<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'coupon.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'coupon.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'coupon.edit');
    }

    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'coupon.delete');
    }
}
