@extends('layouts.admin')

@section('title', 'FAQs')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">FAQs</h2>
        <p class="text-muted mb-0">Questions &amp; answers shown on the public <a href="{{ route('faqs') }}" target="_blank">FAQs</a> page.</p>
    </div>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add FAQ">
        <i class="bi bi-plus-lg me-1"></i> Add FAQ
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.faqs.index', 'placeholder' => 'Search questions…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($faqs as $faq)
                    <tr>
                        <td><span class="text-muted">{{ $loop->iteration + ($faqs->firstItem() ? $faqs->firstItem() - 1 : 0) }}</span></td>
                        <td><span class="fw-semibold">{{ $faq->question }}</span></td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($faq->answer, 80) ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $faq->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.faqs.toggle', $faq) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $faq->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $faq->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit FAQ"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Delete this FAQ?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-patch-question"></i><p class="mb-0 mt-2">No FAQs yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $faqs->firstItem() ?? 0 }}–{{ $faqs->lastItem() ?? 0 }} of {{ $faqs->total() }} FAQs</span>
    {{ $faqs->links() }}
</div>
@endsection
