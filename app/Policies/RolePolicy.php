<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'role.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'role.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'role.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'role.delete');
    }
}
