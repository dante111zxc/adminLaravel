<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'setting.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'setting.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'setting.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'setting.delete');
    }
}
