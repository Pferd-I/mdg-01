<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RevokePfRoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Role $role, Permission $permission): RedirectResponse
    {
        $role->revokePermissionTo($permission);
        return back();
    }
}
