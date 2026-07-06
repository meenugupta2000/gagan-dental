<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /** Roles that must not be edited or deleted. */
    private array $protected = ['super-admin'];

    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->orderBy('name')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(Request $request)
    {
        $permissions = Permission::orderBy('name')->get();

        if ($request->header('X-Drawer')) {
            return view('admin.roles._drawer', [
                'permissions' => $permissions,
                'action' => route('admin.roles.store'),
                'submitLabel' => 'Create Role',
            ]);
        }

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
        $role->syncPermissions($data['permissions'] ?? []);

        return $this->saved($request, 'admin.roles.index', 'Role created successfully.');
    }

    public function edit(Request $request, Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        if ($request->header('X-Drawer')) {
            return view('admin.roles._drawer', [
                'role' => $role,
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions,
                'action' => route('admin.roles.update', $role),
                'method' => 'PUT',
                'submitLabel' => 'Update Role',
            ]);
        }

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        if (in_array($role->name, $this->protected, true)) {
            // Keep the protected role's name; only permissions are managed by the gate anyway.
            $data['name'] = $role->name;
        }

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return $this->saved($request, 'admin.roles.index', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, $this->protected, true)) {
            return back()->withErrors(['role' => 'The Super Admin role cannot be deleted.']);
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
