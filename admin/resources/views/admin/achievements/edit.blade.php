@extends('layouts.admin')

@section('title', 'Edit Achievement')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.achievements.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Achievement</h2>
    <p>Update this achievement.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-trophy"></i></span> {{ \Illuminate\Support\Str::limit($achievement->title, 60) }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.achievements.update', $achievement) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.achievements._form', ['submitLabel' => 'Update Achievement'])
        </form>
    </div>
</div>
@endsection
