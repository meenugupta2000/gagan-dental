@extends('layouts.admin')

@section('title', 'Edit Treatment')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.treatments.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Treatment</h2>
    <p>Update this treatment.</p>
</div>

<div class="card" style="max-width: 820px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-heart-pulse"></i></span> {{ $treatment->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.treatments.update', $treatment) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.treatments._form', ['submitLabel' => 'Update Treatment'])
        </form>
    </div>
</div>
@endsection
