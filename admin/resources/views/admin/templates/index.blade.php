@extends('layouts.admin')

@section('title', 'Email Templates')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1">Email Templates</h2>
    <p>Edit the wording of the automated emails sent by the website.</p>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Template</th>
                    <th>Subject</th>
                    <th style="width:120px;">Status</th>
                    <th class="text-end" style="width:100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($templates as $template)
                    <tr>
                        <td>
                            <span class="fw-semibold d-block">{{ $template->name }}</span>
                            <span class="text-muted small">{{ $template->description }}</span>
                        </td>
                        <td><span class="text-muted small">{{ \Illuminate\Support\Str::limit($template->subject, 60) }}</span></td>
                        <td>
                            <span class="pill {{ $template->is_active ? 'pill-brand' : 'pill-neutral' }}">{{ $template->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.templates.edit', $template) }}" class="btn btn-outline-secondary btn-icon" title="Edit"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state"><i class="bi bi-envelope-paper"></i><p class="mb-0 mt-2">No email templates.</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
