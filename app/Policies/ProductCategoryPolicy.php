<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCategoryPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'productcategory.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'productcategory.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'productcategory.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'productcategory.delete');
    }
}
