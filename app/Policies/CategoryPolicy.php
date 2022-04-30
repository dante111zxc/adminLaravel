<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'category.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'category.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'category.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'category.delete');
    }
}
