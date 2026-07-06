@extends('layouts.admin')

@section('title', 'Offers')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Offers</h2>
        <p class="text-muted mb-0">Promotional offers shown on the website's Offers page.</p>
    </div>
    <a href="{{ route('admin.offers.create') }}" class="btn btn-brand" data-drawer data-drawer-title="Add Offer">
        <i class="bi bi-plus-lg me-1"></i> Add Offer
    </a>
</div>

@include('admin.partials.search-bar', ['resetRoute' => 'admin.offers.index', 'placeholder' => 'Search offers…', 'search' => $search, 'status' => $status])

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:90px;">Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th style="width:70px;">Order</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($offers as $offer)
                    <tr>
                        <td>
                            @if ($offer->image_url)
                                <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" style="width:72px;height:48px;object-fit:cover;border-radius:6px;border:1px solid var(--ltc-border);">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ $offer->title }}</span></td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($offer->description, 80) ?: '—' }}</span></td>
                        <td><span class="pill pill-neutral">{{ $offer->sort_order }}</span></td>
                        <td>
                            <form action="{{ route('admin.offers.toggle', $offer) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        onchange="this.form.submit()" {{ $offer->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small {{ $offer->is_active ? 'text-success' : 'text-muted' }}">
                                        {{ $offer->is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.offers.edit', $offer) }}" class="btn btn-outline-secondary btn-icon" title="Edit" data-drawer data-drawer-title="Edit Offer"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST" onsubmit="return confirm('Delete this offer?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="bi bi-tag"></i><p class="mb-0 mt-2">No offers yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $offers->firstItem() ?? 0 }}–{{ $offers->lastItem() ?? 0 }} of {{ $offers->total() }} offers</span>
    {{ $offers->links() }}
</div>
@endsection
