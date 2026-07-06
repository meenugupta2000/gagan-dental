@extends('layouts.admin')

@section('title', 'Add Page')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.pages.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Page</h2>
    <p>Create an informational page (e.g. a policy).</p>
</div>

<div class="card" style="max-width: 980px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-file-earmark-text"></i></span> New Page</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pages.store') }}">
            @include('admin.pages._form', ['submitLabel' => 'Create Page'])
        </form>
    </div>
</div>
@endsection
