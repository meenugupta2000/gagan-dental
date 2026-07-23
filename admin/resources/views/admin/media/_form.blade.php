@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title <span class="req">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $item->title ?? '') }}" placeholder="e.g. Featured in The Tribune — March 2024" required>
        <div class="form-text">The publication / headline this coverage is from.</div>
    </div>

    <div class="col-12">
        <label class="form-label">Image <span class="req">*</span></label>
        @include('admin.partials.dropzone', [
            'name' => 'image',
            'value' => isset($item) && $item->image_path ? $item->image_url : null,
            'accept' => 'image/png,image/jpeg,image/webp',
            'prompt' => 'Drag & drop the newspaper / magazine clipping here',
            'height' => 200,
        ])
        <div class="form-text">A scan or photo of the newspaper cutting / magazine article. JPG, PNG or WEBP, max 4 MB.</div>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(visible on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.media.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
