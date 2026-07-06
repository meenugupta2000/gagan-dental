@extends('layouts.admin')

@section('title', 'Treatment Categories')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Treatment Categories</h2>
        <p class="text-muted mb-0">Categories used to group clinic treatments.</p>
    </div>
    <a href="{{ route('admin.treatment-categories.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Treatment Category">
        <i class="bi bi-plus-lg me-1"></i> Add Category
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.treatment-categories.index', 'placeholder' => 'Search categories…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:80px;">Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>
                            @if ($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" style="width:60px;height:42px;object-fit:cover;border-radius:6px;border:1px solid var(--ltc-border);">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $category->name }}</span></td>
                        <td><code class="small">{{ $category->slug }}</code></td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($category->description, 80) ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $category->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.treatment-categories.toggle', $category) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $category->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $category->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.treatment-categories.edit', $category) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Treatment Category"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.treatment-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category? Any treatments in it will be unlinked (the treatments themselves are kept).');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="bi bi-collection"></i><p class="mb-0 mt-2">No categories yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} categories</span>
    {{ $categories->links() }}
</div>
@endsection
