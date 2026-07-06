@extends('layouts.admin')

@section('title', 'Message')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.messages.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Message</h2>
    <p>Received {{ $message->created_at->format('d M Y, g:i A') }}</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><span class="sec-icon"><i class="bi bi-envelope-open"></i></span> {{ $message->subject ?: 'No subject' }}</span>
        <a href="mailto:{{ $message->email }}?subject=RE: {{ urlencode($message->subject ?: 'Your enquiry') }}" class="btn btn-brand btn-sm"><i class="bi bi-reply me-1"></i> Reply</a>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="text-muted small">Name</div>
                <div class="fw-semibold">{{ $message->name }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Email</div>
                <div class="fw-semibold"><a href="mailto:{{ $message->email }}" class="text-decoration-none">{{ $message->email }}</a></div>
            </div>
            @if ($message->phone)
            <div class="col-md-6">
                <div class="text-muted small">Phone</div>
                <div class="fw-semibold"><a href="tel:{{ $message->phone }}" class="text-decoration-none">{{ $message->phone }}</a></div>
            </div>
            @endif
        </div>
        <hr>
        <div class="text-muted small mb-1">Message</div>
        <div style="white-space:pre-line;line-height:1.7;">{{ $message->message }}</div>

        <div class="mt-4 d-flex gap-2">
            <a href="mailto:{{ $message->email }}?subject=RE: {{ urlencode($message->subject ?: 'Your enquiry') }}" class="btn btn-brand"><i class="bi bi-reply me-1"></i> Reply by Email</a>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
