<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductTagPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'producttag.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'producttag.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'producttag.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'producttag.delete');
    }
}
