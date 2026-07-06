@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Users</h2>
        <p class="text-muted mb-0">Manage accounts, roles and access.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add User">
        <i class="bi bi-plus-lg me-1"></i> Add User
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <span class="ltc-avatar" style="width:38px;height:38px;border-radius:10px;font-size:.9rem;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <div class="small text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->phone ?: '—' }}</td>
                        <td>
                            @forelse ($user->roles as $role)
                                <span class="pill pill-neutral">{{ $role->name }}</span>
                            @empty
                                <span class="text-muted small">No role</span>
                            @endforelse
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="pill pill-success"><span class="dot"></span> Active</span>
                            @else
                                <span class="pill pill-danger"><span class="dot"></span> Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit User"><i class="bi bi-pencil"></i></a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="empty-state"><i class="bi bi-people"></i><p class="mb-0 mt-2">No users found.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection
