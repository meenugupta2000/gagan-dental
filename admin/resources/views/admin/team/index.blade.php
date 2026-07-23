@extends('layouts.admin')

@section('title', 'Our Team')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Our Team</h2>
        <p class="text-muted mb-0">Team members shown in the "Our Team" section on the <a href="{{ route('home') }}" target="_blank">home page</a>.</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Team Member">
        <i class="bi bi-plus-lg me-1"></i> Add Member
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.team.index', 'placeholder' => 'Search team members…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:80px;">Photo</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Qualification</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>
                            @if ($member->photo_url)
                                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" style="width:52px;height:52px;object-fit:cover;border-radius:50%;border:1px solid var(--ltc-border);">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $member->name }}</span></td>
                        <td><span class="text-muted small">{{ $member->designation ?: '—' }}</span></td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($member->qualification, 60) ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $member->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.team.toggle', $member) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $member->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $member->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $member->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Team Member"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.team.destroy', $member) }}" method="POST" onsubmit="return confirm('Delete {{ $member->name }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="bi bi-people"></i><p class="mb-0 mt-2">No team members yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $members->firstItem() ?? 0 }}–{{ $members->lastItem() ?? 0 }} of {{ $members->total() }} members</span>
    {{ $members->links() }}
</div>
@endsection
