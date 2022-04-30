<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'order.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'order.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'order.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'order.delete');
    }
}
