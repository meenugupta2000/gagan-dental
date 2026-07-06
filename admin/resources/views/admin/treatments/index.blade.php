@extends('layouts.admin')

@section('title', 'Treatments')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Treatments</h2>
        <p class="text-muted mb-0">Dental &amp; aesthetic treatments shown on the website.</p>
    </div>
    <a href="{{ route('admin.treatments.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Treatment">
        <i class="bi bi-plus-lg me-1"></i> Add Treatment
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.treatments.index', 'placeholder' => 'Search treatments…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:80px;">Image</th>
                    <th>Treatment</th>
                    <th style="width:160px;">Category</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($treatments as $treatment)
                    <tr>
                        <td>
                            @if ($treatment->primary_image_url)
                                <img src="{{ $treatment->primary_image_url }}" alt="{{ $treatment->name }}" style="width:64px;height:44px;object-fit:cover;border-radius:6px;border:1px solid var(--ltc-border);">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold d-block">{{ $treatment->name }}</span>
                            <span class="text-muted small">
                                @if ($treatment->duration){{ $treatment->duration }}@endif
                                @if ($treatment->badge) · <span class="pill pill-brand">{{ $treatment->badge }}</span>@endif
                            </span>
                        </td>
                        <td><span class="text-muted small">{{ optional($treatment->category)->name ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $treatment->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.treatments.toggle', $treatment) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $treatment->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $treatment->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $treatment->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.treatments.edit', $treatment) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Treatment"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.treatments.destroy', $treatment) }}" method="POST" onsubmit="return confirm('Delete this treatment? Its images will be removed too.');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-heart-pulse"></i><p class="mb-0 mt-2">No treatments yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $treatments->firstItem() ?? 0 }}–{{ $treatments->lastItem() ?? 0 }} of {{ $treatments->total() }} treatments</span>
    {{ $treatments->links() }}
</div>
@endsection
