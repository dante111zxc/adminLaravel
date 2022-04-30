<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPositionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'menuposition.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'menuposition.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'menuposition.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'menuposition.delete');
    }
}
