@extends('layouts.admin')

@section('title', 'Add Offer')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.offers.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Offer</h2>
    <p>Add a promotional offer.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-tag"></i></span> New Offer</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.offers.store') }}" enctype="multipart/form-data">
            @include('admin.offers._form', ['submitLabel' => 'Create Offer'])
        </form>
    </div>
</div>
@endsection
