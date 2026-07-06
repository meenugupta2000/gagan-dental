@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.faqs.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit FAQ</h2>
    <p>Update this question &amp; answer.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-patch-question"></i></span> {{ \Illuminate\Support\Str::limit($faq->question, 60) }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @method('PUT')
            @include('admin.faqs._form', ['submitLabel' => 'Update FAQ'])
        </form>
    </div>
</div>
@endsection
