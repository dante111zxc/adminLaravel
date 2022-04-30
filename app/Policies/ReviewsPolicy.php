<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewsPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'reviews.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'reviews.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'reviews.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'reviews.delete');
    }
}
