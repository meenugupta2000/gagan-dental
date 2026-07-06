@extends('layouts.admin')

@section('title', 'Subscribers')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Newsletter Subscribers</h2>
        <p class="text-muted mb-0">Emails collected from the website footer subscribe form.</p>
    </div>
    <span class="pill pill-brand align-self-center"><i class="bi bi-people me-1"></i> {{ $subscribers->total() }} total</span>
</div>

<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-sm-8 col-md-6">
                <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Search email…">
            </div>
            <div class="col-sm-4 d-flex gap-2">
                <button class="btn btn-light"><i class="bi bi-search"></i></button>
                @if ($search)
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-light">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Email</th>
                    <th style="width:200px;">Subscribed</th>
                    <th class="text-end" style="width:90px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscribers as $subscriber)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration + ($subscribers->currentPage() - 1) * $subscribers->perPage() }}</td>
                        <td><a href="mailto:{{ $subscriber->email }}" class="fw-semibold text-decoration-none">{{ $subscriber->email }}</a></td>
                        <td class="text-muted small">{{ $subscriber->created_at->format('d M Y, g:i A') }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" onsubmit="return confirm('Remove this subscriber?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-icon" title="Remove"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state"><i class="bi bi-envelope-heart"></i><p class="mb-0 mt-2">No subscribers yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $subscribers->firstItem() ?? 0 }}–{{ $subscribers->lastItem() ?? 0 }} of {{ $subscribers->total() }}</span>
    {{ $subscribers->links() }}
</div>
@endsection
