@csrf
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name ?? '') }}" placeholder="e.g. Sani Laura" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Role / Location</label>
        <input type="text" name="role" class="form-control" value="{{ old('role', $testimonial->role ?? '') }}" placeholder="e.g. Spain">
    </div>

    <div class="col-12">
        <label class="form-label">Headline</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $testimonial->title ?? '') }}" placeholder="e.g. A pain-free experience!">
    </div>

    <div class="col-12">
        <label class="form-label">Testimonial <span class="req">*</span></label>
        <textarea name="quote" rows="4" class="form-control" placeholder="What the patient said…" required>{{ old('quote', $testimonial->quote ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Rating</label>
        <select name="rating" class="form-select">
            @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ (int) old('rating', $testimonial->rating ?? 5) === $i ? 'selected' : '' }}>{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
    </div>

    <div class="col-12">
        <label class="form-label">Photo</label>
        @include('admin.partials.dropzone', [
            'name' => 'photo',
            'value' => isset($testimonial) && $testimonial->photo_path ? $testimonial->photo_url : null,
            'accept' => 'image/png,image/jpeg,image/webp',
            'prompt' => 'Drag & drop a photo here',
            'height' => 150,
        ])
        <div class="form-text">Recommended <strong>300 × 300 px</strong> (square headshot). PNG, JPG or WEBP, max 2 MB.</div>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(shown on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
