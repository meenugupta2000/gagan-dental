<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(config('admin.per_page'));

        return view('admin.users.index', compact('users'));
    }

    public function create(Request $request)
    {
        $roles = Role::orderBy('name')->get();

        if ($request->header('X-Drawer')) {
            return view('admin.users._drawer', [
                'roles' => $roles,
                'action' => route('admin.users.store'),
                'submitLabel' => 'Create User',
            ]);
        }

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'is_active' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'is_active' => $request->boolean('is_active'),
        ]);

        $user->syncRoles($data['roles'] ?? []);

        return $this->saved($request, 'admin.users.index', 'User created successfully.');
    }

    public function edit(Request $request, User $user)
    {
        $roles = Role::orderBy('name')->get();
        $userRoles = $user->roles->pluck('name')->toArray();

        if ($request->header('X-Drawer')) {
            return view('admin.users._drawer', [
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $userRoles,
                'action' => route('admin.users.update', $user),
                'method' => 'PUT',
                'submitLabel' => 'Update User',
            ]);
        }

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_active' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,name'],
        ]);

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        // Protect the last super admin from losing the role.
        if ($this->wouldRemoveLastSuperAdmin($user, $data['roles'] ?? [])) {
            throw ValidationException::withMessages(['roles' => 'You cannot remove the last Super Admin.']);
        }

        $user->syncRoles($data['roles'] ?? []);

        return $this->saved($request, 'admin.users.index', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        if ($user->hasRole('super-admin') && User::role('super-admin')->count() <= 1) {
            return back()->withErrors(['user' => 'You cannot delete the last Super Admin.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function wouldRemoveLastSuperAdmin(User $user, array $newRoles): bool
    {
        if (! $user->hasRole('super-admin')) {
            return false;
        }

        $keepsSuperAdmin = in_array('super-admin', $newRoles, true);

        return ! $keepsSuperAdmin && User::role('super-admin')->count() <= 1;
    }
}
