@extends('layouts.admin')

@section('title', 'Achievements')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Achievements</h2>
        <p class="text-muted mb-0">Awards, certificates &amp; honours shown on the public <a href="{{ route('achievements') }}" target="_blank">Achievements</a> page.</p>
    </div>
    <a href="{{ route('admin.achievements.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Achievement">
        <i class="bi bi-plus-lg me-1"></i> Add Achievement
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.achievements.index', 'placeholder' => 'Search achievements…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:90px;">Photo</th>
                    <th>Title</th>
                    <th>Notes</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($achievements as $achievement)
                    <tr>
                        <td>
                            @if ($achievement->image_url)
                                <img src="{{ $achievement->image_url }}" alt="{{ $achievement->title }}" style="width:72px;height:52px;object-fit:cover;border-radius:6px;border:1px solid var(--ltc-border);">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $achievement->title }}</span></td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($achievement->notes, 70) ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $achievement->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.achievements.toggle', $achievement) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $achievement->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $achievement->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $achievement->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Achievement"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" onsubmit="return confirm('Delete {{ $achievement->title }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-trophy"></i><p class="mb-0 mt-2">No achievements yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $achievements->firstItem() ?? 0 }}–{{ $achievements->lastItem() ?? 0 }} of {{ $achievements->total() }} achievements</span>
    {{ $achievements->links() }}
</div>
@endsection
