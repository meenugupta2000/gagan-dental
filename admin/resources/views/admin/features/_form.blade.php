@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title <span class="req">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $feature->title ?? '') }}" placeholder="e.g. No Hidden Fees" required>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="2" class="form-control" placeholder="A short supporting sentence.">{{ old('description', $feature->description ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label">Icon</label>
        @include('admin.partials.dropzone', [
            'name' => 'icon',
            'value' => isset($feature) && $feature->icon_path ? $feature->icon_url : null,
            'prompt' => 'Drag & drop an icon here',
            'height' => 150,
        ])
        <div class="form-text">Recommended <strong>96 × 96 px</strong> (square). PNG, JPG, WEBP or SVG. Max 2 MB.</div>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $feature->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $feature->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active</label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.features.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
