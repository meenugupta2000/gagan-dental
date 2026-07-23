@extends('layouts.admin')

@section('title', 'Add Media Item')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.media.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Media Item</h2>
    <p>Add a newspaper or magazine coverage image shown in the Media Gallery.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-newspaper"></i></span> New Media Item</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
            @include('admin.media._form', ['submitLabel' => 'Create Item'])
        </form>
    </div>
</div>
@endsection
