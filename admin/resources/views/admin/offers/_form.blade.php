@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title <span class="req">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $offer->title ?? '') }}" placeholder="e.g. Teeth Whitening — 30% Off This Month" required>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="5" class="form-control" placeholder="Describe the offer, what's included, terms, etc.">{{ old('description', $offer->description ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label">Image</label>
        @include('admin.partials.dropzone', [
            'name' => 'image',
            'value' => isset($offer) && $offer->image_path ? $offer->image_url : null,
            'accept' => 'image/png,image/jpeg,image/webp',
            'prompt' => 'Drag & drop the offer image here',
            'height' => 190,
        ])
        <div class="form-text">Recommended <strong>800 × 600 px</strong> (landscape, 4:3). JPG, PNG or WEBP, max 4 MB.</div>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $offer->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $offer->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(shown on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.offers.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
