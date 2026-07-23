@extends('layouts.admin')

@section('title', 'Add Team Member')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.team.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Team Member</h2>
    <p>Add a team member shown in the "Our Team" section on the home page.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-people"></i></span> New Team Member</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">
            @include('admin.team._form', ['submitLabel' => 'Create Member'])
        </form>
    </div>
</div>
@endsection
