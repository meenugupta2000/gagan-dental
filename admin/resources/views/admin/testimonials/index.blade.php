@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Testimonials</h2>
        <p class="text-muted mb-0">Patient reviews shown in the "What our patients say" slider.</p>
    </div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Testimonial">
        <i class="bi bi-plus-lg me-1"></i> Add Testimonial
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.testimonials.index', 'placeholder' => 'Search name, role or headline…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:60px;">Photo</th>
                    <th>Author</th>
                    <th>Testimonial</th>
                    <th style="width:110px;">Rating</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($testimonials as $testimonial)
                    <tr>
                        <td>
                            @if ($testimonial->photo_url)
                                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" style="width:42px;height:42px;object-fit:cover;border-radius:50%;">
                            @else
                                <span class="ltc-avatar" style="width:42px;height:42px;border-radius:50%;font-size:.9rem;">{{ strtoupper(substr($testimonial->name, 0, 1)) }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $testimonial->name }}</div>
                            <div class="small text-muted">{{ $testimonial->role }}</div>
                        </td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($testimonial->quote, 70) }}</span></td>
                        <td><span class="text-warning">{{ str_repeat('★', $testimonial->rating) }}</span><span class="text-muted">{{ str_repeat('★', 5 - $testimonial->rating) }}</span></td>
                        <td><span class="pill pill-neutral">{{ $testimonial->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.testimonials.toggle', $testimonial) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $testimonial->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $testimonial->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Testimonial"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Delete this testimonial?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="bi bi-chat-quote"></i><p class="mb-0 mt-2">No testimonials yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $testimonials->firstItem() ?? 0 }}–{{ $testimonials->lastItem() ?? 0 }} of {{ $testimonials->total() }} testimonials</span>
    {{ $testimonials->links() }}
</div>
@endsection
