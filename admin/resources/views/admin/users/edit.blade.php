@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit User</h2>
    <p>Update account details, status and roles.</p>
</div>

<div class="card" style="max-width: 880px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-person-gear"></i></span> {{ $user->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @method('PUT')
            @include('admin.users._form', ['submitLabel' => 'Update User'])
        </form>
    </div>
</div>
@endsection
