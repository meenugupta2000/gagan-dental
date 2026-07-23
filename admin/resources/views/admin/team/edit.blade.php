@extends('layouts.admin')

@section('title', 'Edit Team Member')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.team.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Team Member</h2>
    <p>Update this team member.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-people"></i></span> {{ \Illuminate\Support\Str::limit($member->name, 60) }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.team._form', ['submitLabel' => 'Update Member'])
        </form>
    </div>
</div>
@endsection
