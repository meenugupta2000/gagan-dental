@extends('layouts.admin')

@section('title', 'Edit Feature')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.features.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Feature</h2>
    <p>Update this feature card.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-stars"></i></span> {{ $feature->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.features.update', $feature) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.features._form', ['submitLabel' => 'Update Feature'])
        </form>
    </div>
</div>
@endsection
