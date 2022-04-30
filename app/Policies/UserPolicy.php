<?php

namespace App\Policies;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'user.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'user.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'user.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'user.delete');
    }
}
