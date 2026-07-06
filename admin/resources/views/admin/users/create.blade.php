@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add User</h2>
    <p>Create a new account and assign roles.</p>
</div>

<div class="card" style="max-width: 880px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-person-plus"></i></span> New User</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @include('admin.users._form', ['submitLabel' => 'Create User'])
        </form>
    </div>
</div>
@endsection
