@extends('layouts.admin')

@section('title', 'Add Achievement')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.achievements.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Achievement</h2>
    <p>Add an award, certificate or honour shown on the public Achievements page.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-trophy"></i></span> New Achievement</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.achievements.store') }}" enctype="multipart/form-data">
            @include('admin.achievements._form', ['submitLabel' => 'Create Achievement'])
        </form>
    </div>
</div>
@endsection
