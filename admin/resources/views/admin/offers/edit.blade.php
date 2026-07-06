@extends('layouts.admin')

@section('title', 'Edit Offer')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.offers.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Offer</h2>
    <p>Update this offer.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-tag"></i></span> {{ $offer->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.offers.update', $offer) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.offers._form', ['submitLabel' => 'Update Offer'])
        </form>
    </div>
</div>
@endsection
