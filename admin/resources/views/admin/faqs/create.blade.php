@extends('layouts.admin')

@section('title', 'Add FAQ')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.faqs.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add FAQ</h2>
    <p>Add a question &amp; answer shown on the public FAQs page.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-patch-question"></i></span> New FAQ</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @include('admin.faqs._form', ['submitLabel' => 'Create FAQ'])
        </form>
    </div>
</div>
@endsection
