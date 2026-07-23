@extends('layouts.admin')

@section('title', 'Media Gallery')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Media Gallery</h2>
        <p class="text-muted mb-0">Newspaper &amp; magazine coverage shown on the public <a href="{{ route('media') }}" target="_blank">Media Gallery</a> page.</p>
    </div>
    <a href="{{ route('admin.media.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Media Item">
        <i class="bi bi-plus-lg me-1"></i> Add Media
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.media.index', 'placeholder' => 'Search media…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:90px;">Image</th>
                    <th>Title</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($media as $item)
                    <tr>
                        <td>
                            @if ($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:72px;height:52px;object-fit:cover;border-radius:6px;border:1px solid var(--ltc-border);">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $item->title }}</span></td>
                        <td><span class="pill pill-neutral">{{ $item->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.media.toggle', $item) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $item->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $item->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Media Item"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete {{ $item->title }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="empty-state"><i class="bi bi-newspaper"></i><p class="mb-0 mt-2">No media items yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $media->firstItem() ?? 0 }}–{{ $media->lastItem() ?? 0 }} of {{ $media->total() }} items</span>
    {{ $media->links() }}
</div>
@endsection
