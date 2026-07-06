@extends('layouts.admin')

@section('title', 'Roles & Permissions')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Roles &amp; Permissions</h2>
        <p class="text-muted mb-0">Define what each type of user can access.</p>
    </div>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Role">
        <i class="bi bi-plus-lg me-1"></i> Add Role
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Users</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>
                            <span class="fw-semibold text-capitalize">{{ str_replace('-', ' ', $role->name) }}</span>
                            @if ($role->name === 'super-admin')
                                <span class="pill pill-warn ms-1"><i class="bi bi-shield-lock"></i> protected</span>
                            @endif
                        </td>
                        <td>
                            @if ($role->name === 'super-admin')
                                <span class="text-muted small">All permissions (full access)</span>
                            @else
                                <span class="pill pill-brand">{{ $role->permissions_count }} permission{{ $role->permissions_count === 1 ? '' : 's' }}</span>
                            @endif
                        </td>
                        <td><span class="pill pill-neutral">{{ $role->users_count }}</span></td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Role"><i class="bi bi-pencil"></i></a>
                                @if ($role->name !== 'super-admin')
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Delete this role?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state"><i class="bi bi-shield-lock"></i><p class="mb-0 mt-2">No roles found.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
