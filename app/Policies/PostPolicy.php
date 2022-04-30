<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;



   public function view (Admin $admin){
       return Admin::hasPermission($admin->role_id, 'post.view');
   }

   public function create (Admin $admin) {
       return Admin::hasPermission($admin->role_id, 'post.create');
   }

   public function edit (Admin $admin) {
       return Admin::hasPermission($admin->role_id, 'post.edit');
   }


   public function delete (Admin $admin) {
       return Admin::hasPermission($admin->role_id, 'post.delete');
   }
}
