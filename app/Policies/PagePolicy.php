<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'page.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'page.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'page.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'page.delete');
    }
}
