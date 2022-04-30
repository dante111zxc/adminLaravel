<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;


    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'product.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'product.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'product.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'product.delete');
    }
}
