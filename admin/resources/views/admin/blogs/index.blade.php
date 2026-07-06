@extends('layouts.admin')

@section('title', 'Blogs')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Blogs</h2>
        <p class="text-muted mb-0">Articles shown on the website's Blog page.</p>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Blog">
        <i class="bi bi-plus-lg me-1"></i> Add Blog
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.blogs.index', 'placeholder' => 'Search blogs…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:90px;">Image</th>
                    <th>Title</th>
                    <th>Excerpt</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                    <tr>
                        <td>
                            @if ($blog->image_url)
                                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" style="width:72px;height:48px;object-fit:cover;border-radius:6px;border:1px solid var(--ltc-border);">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $blog->title }}</span></td>
                        <td><span class="text-muted small">{{ $blog->excerpt ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $blog->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.blogs.toggle', $blog) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $blog->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $blog->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $blog->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Blog"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete this blog?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-journal-text"></i><p class="mb-0 mt-2">No blogs yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $blogs->firstItem() ?? 0 }}–{{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }} blogs</span>
    {{ $blogs->links() }}
</div>
@endsection
