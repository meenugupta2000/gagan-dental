@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Contact Messages</h2>
        <p class="text-muted mb-0">Enquiries submitted through the website contact form.</p>
    </div>
    @if ($unread)
        <span class="pill pill-brand align-self-center"><i class="bi bi-envelope-fill me-1"></i> {{ $unread }} unread</span>
    @endif
</div>

<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-sm-8 col-md-6">
                <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Search name, email or subject…">
            </div>
            <div class="col-sm-4 d-flex gap-2">
                <button class="btn btn-light"><i class="bi bi-search"></i></button>
                @if ($search)<a href="{{ route('admin.messages.index') }}" class="btn btn-light">Reset</a>@endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:40px;"></th>
                    <th style="width:150px;">Name</th>
                    <th style="width:210px;">Email</th>
                    <th style="width:140px;">Phone</th>
                    <th style="width:160px;">Subject</th>
                    <th>Message</th>
                    <th style="width:150px;">Received</th>
                    <th class="text-end" style="width:110px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'fw-semibold' }}">
                        <td>@unless($message->is_read)<span class="dot" style="display:inline-block;width:9px;height:9px;border-radius:50%;background:var(--ltc-brand);"></span>@endunless</td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-decoration-none fw-semibold">{{ $message->name }}</a>
                        </td>
                        <td><a href="mailto:{{ $message->email }}" class="text-decoration-none small">{{ $message->email }}</a></td>
                        <td>
                            @if ($message->phone)
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $message->phone) }}" class="text-decoration-none small">{{ $message->phone }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="text-muted small">{{ $message->subject ? \Illuminate\Support\Str::limit($message->subject, 40) : '—' }}</span></td>
                        <td><span class="text-muted small" title="{{ $message->message }}">{{ \Illuminate\Support\Str::limit($message->message, 90) }}</span></td>
                        <td class="text-muted small">{{ $message->created_at->format('d M Y, g:i A') }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-outline-secondary btn-icon" title="View"><i class="bi bi-eye"></i></a>
                                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="empty-state"><i class="bi bi-inbox"></i><p class="mb-0 mt-2">No messages yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $messages->firstItem() ?? 0 }}–{{ $messages->lastItem() ?? 0 }} of {{ $messages->total() }}</span>
    {{ $messages->links() }}
</div>
@endsection
