@extends('layouts.admin')

@section('title', 'Appointments')

@section('content')
@php($search = $search ?? request('q', ''))
@php($status = $status ?? request('status', ''))
@php($badges = ['new' => 'primary', 'contacted' => 'info', 'confirmed' => 'warning', 'completed' => 'success', 'cancelled' => 'secondary'])

<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div>
        <h2 class="h4 fw-bold mb-1">Appointments</h2>
        <p class="text-muted mb-0">Appointment requests submitted through the website booking form.</p>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-sm-6 col-md-5">
                <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Search name, phone or email…">
            </div>
            <div class="col-sm-4 col-md-3">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    @foreach (\App\Models\Appointment::STATUSES as $s)
                        <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2 col-md-2 d-flex gap-2">
                <button class="btn btn-light"><i class="bi bi-search"></i></button>
                @if ($search || $status)
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-light">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width:170px;">Name</th>
                    <th style="width:140px;">Phone</th>
                    <th style="width:180px;">Treatment</th>
                    <th style="width:170px;">Preferred Slot</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:150px;">Received</th>
                    <th class="text-end" style="width:110px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-decoration-none fw-semibold">{{ $appointment->name }}</a>
                        </td>
                        <td>
                            @if ($appointment->phone)
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $appointment->phone) }}" class="text-decoration-none small">{{ $appointment->phone }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td><span class="text-muted small">{{ $appointment->treatment_label ?: '—' }}</span></td>
                        <td>
                            <span class="text-muted small">
                                @if ($appointment->preferred_date)
                                    {{ $appointment->preferred_date->format('d M Y') }}@if ($appointment->preferred_time), {{ $appointment->preferred_time }}@endif
                                @elseif ($appointment->preferred_time)
                                    {{ $appointment->preferred_time }}
                                @else
                                    —
                                @endif
                            </span>
                        </td>
                        <td><span class="badge text-bg-{{ $badges[$appointment->status] ?? 'secondary' }}">{{ ucfirst($appointment->status) }}</span></td>
                        <td class="text-muted small">{{ $appointment->created_at->format('d M Y, g:i A') }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-outline-secondary btn-icon" title="View"><i class="bi bi-eye"></i></a>
                                <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment request?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-icon" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="bi bi-calendar-check"></i><p class="mb-0 mt-2">No appointment requests yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="text-muted small">Showing {{ $appointments->firstItem() ?? 0 }}–{{ $appointments->lastItem() ?? 0 }} of {{ $appointments->total() }}</span>
    {{ $appointments->links() }}
</div>
@endsection
