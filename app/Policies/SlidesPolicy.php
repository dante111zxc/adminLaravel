<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlidesPolicy
{
    use HandlesAuthorization;


    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'slides.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'slides.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'slides.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'slides.delete');
    }
}
