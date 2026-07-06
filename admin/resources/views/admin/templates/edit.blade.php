@extends('layouts.admin')

@section('title', 'Edit Email Template')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.templates.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> {{ $template->name }}</h2>
    <p>{{ $template->description }}</p>
</div>

<form method="POST" action="{{ route('admin.templates.update', $template) }}">
    @csrf
    @method('PUT')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-envelope-paper"></i></span> Email Content</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Subject <span class="req">*</span></label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject', $template->subject) }}" required>
                        @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Body <span class="req">*</span></label>
                        <input id="tpl_body" type="hidden" name="body" value="{{ old('body', $template->body) }}">
                        <trix-toolbar id="tpl-toolbar"></trix-toolbar>
                        <trix-editor input="tpl_body" toolbar="tpl-toolbar" class="trix-content"></trix-editor>
                        @error('body')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                            {{ old('is_active', $template->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(send this email)</span></label>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-brand"><i class="bi bi-save me-1"></i> Save Template</button>
                <a href="{{ route('admin.templates.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-braces"></i></span> Placeholders</div>
                <div class="card-body">
                    <p class="text-muted small">Insert these in the subject or body — they are replaced with the real values when the email is sent.</p>
                    <ul class="list-unstyled mb-0">
                        @foreach ($placeholders as $token => $desc)
                            <li class="mb-2"><code>&#123;&#123; {{ $token }} &#125;&#125;</code><span class="text-muted small d-block">{{ $desc }}</span></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
