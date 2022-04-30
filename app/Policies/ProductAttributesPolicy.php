<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductAttributesPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'productattributes.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'productattributes.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'productattributes.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'productattributes.delete');
    }
}
