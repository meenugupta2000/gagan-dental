@extends('layouts.admin')

@section('title', 'Features')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Features</h2>
        <p class="text-muted mb-0">The "Why choose us" cards shown on the home page.</p>
    </div>
    <a href="{{ route('admin.features.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Feature">
        <i class="bi bi-plus-lg me-1"></i> Add Feature
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.features.index', 'placeholder' => 'Search features…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:70px;">Icon</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($features as $feature)
                    <tr>
                        <td>
                            @if ($feature->icon_url)
                                <img src="{{ $feature->icon_url }}" alt="{{ $feature->title }}" style="width:40px;height:40px;object-fit:contain;">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $feature->title }}</span></td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($feature->description, 70) ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $feature->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.features.toggle', $feature) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $feature->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $feature->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $feature->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Feature"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.features.destroy', $feature) }}" method="POST" onsubmit="return confirm('Delete {{ $feature->title }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-stars"></i><p class="mb-0 mt-2">No features yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $features->firstItem() ?? 0 }}–{{ $features->lastItem() ?? 0 }} of {{ $features->total() }} features</span>
    {{ $features->links() }}
</div>
@endsection
