@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <h2>Welcome back, {{ auth()->user()->name }} 👋</h2>
    <p>Here's your {{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }} admin overview.</p>
</div>

@php($cards = [
    ['key' => 'appointments_new',   'label' => 'New Appointments',   'icon' => 'bi-calendar-plus',   'color' => '#1d5fa8', 'bg' => '#e8f1fd', 'route' => 'admin.appointments.index', 'permission' => 'manage appointments'],
    ['key' => 'appointments_total', 'label' => 'Total Appointments', 'icon' => 'bi-calendar-check',  'color' => '#0f766e', 'bg' => '#e0f2f1', 'route' => 'admin.appointments.index', 'permission' => 'manage appointments'],
    ['key' => 'messages_unread',    'label' => 'Unread Messages',    'icon' => 'bi-envelope-exclamation', 'color' => '#b45309', 'bg' => '#fef3e2', 'route' => 'admin.messages.index', 'permission' => 'manage messages'],
    ['key' => 'treatments',         'label' => 'Treatments',         'icon' => 'bi-heart-pulse',     'color' => '#154a1a', 'bg' => '#e7f4ea', 'route' => 'admin.treatments.index', 'permission' => 'manage treatments'],
    ['key' => 'blogs',              'label' => 'Blog Posts',         'icon' => 'bi-journal-text',    'color' => '#7a5cc4', 'bg' => '#f0eafb', 'route' => 'admin.blogs.index', 'permission' => 'manage blogs'],
    ['key' => 'testimonials',       'label' => 'Testimonials',       'icon' => 'bi-chat-quote',      'color' => '#0369a1', 'bg' => '#e0f2fe', 'route' => 'admin.testimonials.index', 'permission' => 'manage testimonials'],
    ['key' => 'subscribers',        'label' => 'Subscribers',        'icon' => 'bi-envelope-heart',  'color' => '#be185d', 'bg' => '#fce7f3', 'route' => 'admin.subscribers.index', 'permission' => 'manage subscribers'],
])

<div class="row g-3 mb-4">
    @foreach ($cards as $card)
        <div class="col-6 col-lg-3">
            <div class="card stat-card h-100 position-relative">
                <div class="card-body d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-label mb-2">{{ $card['label'] }}</div>
                        <div class="stat-value">{{ $stats[$card['key']] ?? 0 }}</div>
                        @can($card['permission'])
                            <a href="{{ route($card['route']) }}" class="small text-decoration-none stretched-link">View <i class="bi bi-arrow-right"></i></a>
                        @endcan
                    </div>
                    <span class="stat-icon" style="background: {{ $card['bg'] }}; color: {{ $card['color'] }};">
                        <i class="bi {{ $card['icon'] }}"></i>
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>

@can('manage appointments')
@php($badges = ['new' => 'primary', 'contacted' => 'info', 'confirmed' => 'warning', 'completed' => 'success', 'cancelled' => 'secondary'])
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><span class="sec-icon"><i class="bi bi-calendar-check"></i></span> Recent appointment requests</span>
        <a href="{{ route('admin.appointments.index') }}" class="btn btn-light btn-sm">View all</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width:140px;">Phone</th>
                    <th style="width:180px;">Treatment</th>
                    <th style="width:170px;">Preferred Slot</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:150px;">Received</th>
                    <th class="text-end" style="width:70px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentAppointments as $appointment)
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
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-outline-secondary btn-icon" title="View"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7"><div class="empty-state"><i class="bi bi-calendar-check"></i><p class="mb-0 mt-2">No appointment requests yet.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endcan
@endsection
