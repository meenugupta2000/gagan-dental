@extends('layouts.admin')

@section('title', 'Edit Role')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.roles.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Role</h2>
    <p>Update this role's name and permissions.</p>
</div>

<div class="card" style="max-width: 880px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-shield-lock"></i></span> <span class="text-capitalize">{{ str_replace('-', ' ', $role->name) }}</span></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
            @method('PUT')
            @include('admin.roles._form', ['submitLabel' => 'Update Role'])
        </form>
    </div>
</div>
@endsection
