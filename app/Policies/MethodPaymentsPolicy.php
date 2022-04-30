<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class MethodPaymentsPolicy
{
    use HandlesAuthorization;

    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'methodpayments.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'methodpayments.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'methodpayments.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'methodpayments.delete');
    }
}
