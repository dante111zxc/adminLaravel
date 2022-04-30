<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPcoinPolicy
{
    use HandlesAuthorization;
    public function view (Admin $admin){
        return Admin::hasPermission($admin->role_id, 'transactionpcoin.view');
    }

    public function create (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'transactionpcoin.create');
    }

    public function edit (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'transactionpcoin.edit');
    }


    public function delete (Admin $admin) {
        return Admin::hasPermission($admin->role_id, 'transactionpcoin.delete');
    }
}
