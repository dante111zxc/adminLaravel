<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;
    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'tag.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'tag.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'tag.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'tag.delete');
    }
}
