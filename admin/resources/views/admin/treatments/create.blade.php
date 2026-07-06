@extends('layouts.admin')

@section('title', 'Add Treatment')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.treatments.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Treatment</h2>
    <p>Add a dental or aesthetic treatment.</p>
</div>

<div class="card" style="max-width: 820px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-heart-pulse"></i></span> New Treatment</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.treatments.store') }}" enctype="multipart/form-data">
            @include('admin.treatments._form', ['submitLabel' => 'Create Treatment'])
        </form>
    </div>
</div>
@endsection
