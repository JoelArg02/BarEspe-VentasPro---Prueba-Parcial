<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
  public function createRol()
  {
    $role = Role::create(['name' => 'client']);
    return redirect()->route('dashboard');
  }

  public function assignRoleAdmin()
  {
    $user = User::find(1);
    $user->assignRole('admin');
    return redirect()->route('dashboard');
  }
}
