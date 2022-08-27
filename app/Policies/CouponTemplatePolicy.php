<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponTemplatePolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'coupontemplate.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'coupontemplate.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'coupontemplate.edit');
    }

    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'coupontemplate.delete');
    }
}
