@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Testimonial Heading <span class="req">*</span></label>
        <input type="text" name="heading" class="form-control" value="{{ old('heading', $videoTestimonial->heading ?? '') }}" placeholder="e.g. A Life-Changing Dental Implants Journey" required>
    </div>

    <div class="col-12">
        <label class="form-label">YouTube Video Link <span class="req">*</span></label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-youtube text-danger"></i></span>
            <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $videoTestimonial->youtube_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=..." required>
        </div>
        <div class="form-text">Paste any YouTube link — <code>watch?v=…</code>, <code>youtu.be/…</code> or <code>shorts/…</code>. The thumbnail and player are generated automatically.</div>
    </div>

    <div class="col-12">
        <label class="form-label">Notes / Description</label>
        <textarea name="notes" rows="3" class="form-control" placeholder="A short description of what this testimonial covers.">{{ old('notes', $videoTestimonial->notes ?? '') }}</textarea>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $videoTestimonial->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $videoTestimonial->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(visible on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.video-testimonials.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
