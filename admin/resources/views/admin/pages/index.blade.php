@extends('layouts.admin')

@section('title', 'Pages')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Pages</h2>
        <p class="text-muted mb-0">Editable content pages such as Privacy Policy and Terms &amp; Conditions.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-brand">
        <i class="bi bi-plus-lg me-1"></i> Add Page
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>URL</th>
                    <th style="width:130px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td><span class="fw-semibold">{{ $page->title }}</span></td>
                        <td><a href="{{ route('page', $page->slug) }}" target="_blank" class="text-muted small text-decoration-none">/page/{{ $page->slug }} <i class="bi bi-box-arrow-up-right"></i></a></td>
                        <td>
                            <form action="{{ route('admin.pages.toggle', $page) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $page->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $page->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $page->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline-secondary btn-icon" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Delete {{ $page->title }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state"><i class="bi bi-file-earmark-text"></i><p class="mb-0 mt-2">No pages yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $pages->links() }}</div>
@endsection
