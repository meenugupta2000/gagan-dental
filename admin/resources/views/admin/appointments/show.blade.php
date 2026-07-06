@extends('layouts.admin')

@section('title', 'Appointment')

@section('content')
@php($badges = ['new' => 'primary', 'contacted' => 'info', 'confirmed' => 'warning', 'completed' => 'success', 'cancelled' => 'secondary'])

<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.appointments.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Appointment Request</h2>
    <p>Received {{ $appointment->created_at->format('d M Y, g:i A') }}</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><span class="sec-icon"><i class="bi bi-calendar-check"></i></span> {{ $appointment->name }}</span>
        <span class="badge text-bg-{{ $badges[$appointment->status] ?? 'secondary' }}">{{ ucfirst($appointment->status) }}</span>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="text-muted small">Name</div>
                <div class="fw-semibold">{{ $appointment->name }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Phone</div>
                <div class="fw-semibold">
                    @if ($appointment->phone)
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $appointment->phone) }}" class="text-decoration-none">{{ $appointment->phone }}</a>
                    @else
                        —
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Email</div>
                <div class="fw-semibold">
                    @if ($appointment->email)
                        <a href="mailto:{{ $appointment->email }}" class="text-decoration-none">{{ $appointment->email }}</a>
                    @else
                        —
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Treatment</div>
                <div class="fw-semibold">{{ $appointment->treatment_label ?: '—' }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Preferred Date</div>
                <div class="fw-semibold">{{ $appointment->preferred_date ? $appointment->preferred_date->format('d M Y') : '—' }}</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Preferred Time</div>
                <div class="fw-semibold">{{ $appointment->preferred_time ?: '—' }}</div>
            </div>
        </div>
        <hr>
        <div class="text-muted small mb-1">Message</div>
        <div style="white-space:pre-line;line-height:1.7;">{{ $appointment->message ?: '—' }}</div>

        <hr>
        <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST" class="row g-2 align-items-end" style="max-width: 420px;">
            @csrf @method('PATCH')
            <div class="col-8">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach (\App\Models\Appointment::STATUSES as $s)
                        <option value="{{ $s }}" {{ old('status', $appointment->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-brand w-100"><i class="bi bi-check2 me-1"></i> Save</button>
            </div>
        </form>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-light"><i class="bi bi-arrow-left me-1"></i> Back to Appointments</a>
            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment request?');">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
