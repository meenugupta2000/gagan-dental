@extends('layouts.admin')

@section('title', 'Add Role')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.roles.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Role</h2>
    <p>Create a role and choose its permissions.</p>
</div>

<div class="card" style="max-width: 880px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-shield-plus"></i></span> New Role</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @include('admin.roles._form', ['submitLabel' => 'Create Role'])
        </form>
    </div>
</div>
@endsection
