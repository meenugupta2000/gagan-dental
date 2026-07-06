@extends('layouts.admin')

@section('title', 'Video Testimonials')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Video Testimonials</h2>
        <p class="text-muted mb-0">YouTube video testimonials shown on the public <a href="{{ route('testimonials') }}" target="_blank">Testimonials</a> page.</p>
    </div>
    <a href="{{ route('admin.video-testimonials.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Video Testimonial">
        <i class="bi bi-plus-lg me-1"></i> Add Video Testimonial
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.video-testimonials.index', 'placeholder' => 'Search testimonials…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:110px;">Video</th>
                    <th>Heading</th>
                    <th>Notes</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($videos as $video)
                    <tr>
                        <td>
                            @if ($video->thumbnail_url)
                                <a href="{{ $video->watch_url }}" target="_blank" rel="noopener" class="d-inline-block position-relative" title="Open on YouTube" style="width:96px;">
                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->heading }}" style="width:96px;height:56px;object-fit:cover;border-radius:6px;border:1px solid var(--ltc-border);">
                                    <i class="bi bi-play-circle-fill position-absolute top-50 start-50 translate-middle text-white" style="font-size:1.4rem;text-shadow:0 1px 6px rgba(0,0,0,.6);"></i>
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $video->heading }}</span></td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($video->notes, 70) ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $video->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.video-testimonials.toggle', $video) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $video->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $video->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $video->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.video-testimonials.edit', $video) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Video Testimonial"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.video-testimonials.destroy', $video) }}" method="POST" onsubmit="return confirm('Delete {{ $video->heading }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-camera-video"></i><p class="mb-0 mt-2">No video testimonials yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $videos->firstItem() ?? 0 }}–{{ $videos->lastItem() ?? 0 }} of {{ $videos->total() }} video testimonials</span>
    {{ $videos->links() }}
</div>
@endsection
