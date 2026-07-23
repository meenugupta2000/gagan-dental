@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $member->name ?? '') }}" placeholder="e.g. Dr. Gaganpreet Kaur" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Designation</label>
        <input type="text" name="designation" class="form-control" value="{{ old('designation', $member->designation ?? '') }}" placeholder="e.g. Chief Dental &amp; Aesthetic Surgeon">
        <div class="form-text">The person's role at the clinic.</div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Qualification</label>
        <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $member->qualification ?? '') }}" placeholder="e.g. BDS, MDS — Cosmetology">
        <div class="form-text">Degrees / certifications.</div>
    </div>

    <div class="col-12">
        <label class="form-label">Photo</label>
        @include('admin.partials.dropzone', [
            'name' => 'photo',
            'value' => isset($member) && $member->photo_path ? $member->photo_url : null,
            'accept' => 'image/png,image/jpeg,image/webp',
            'prompt' => 'Drag & drop the member photo here (portrait, e.g. 600 × 750 px)',
            'height' => 190,
        ])
        <div class="form-text">A clear head-and-shoulders portrait works best. Recommended <strong>600 × 750 px</strong> (portrait). JPG, PNG or WEBP, max 4 MB.</div>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $member->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(visible on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.team.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
