<?php

namespace App\Policies;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'admin.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'admin.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'admin.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'admin.delete');
    }
}
