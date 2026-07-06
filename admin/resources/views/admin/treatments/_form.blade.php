@csrf
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Treatment Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $treatment->name ?? '') }}" placeholder="e.g. Teeth Whitening" required>
        @isset($treatment)
            <div class="form-text">Slug: <code>{{ $treatment->slug }}</code> <span class="text-muted">(auto from name)</span></div>
        @endisset
    </div>

    <div class="col-md-4">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" class="form-control" value="{{ old('duration', $treatment->duration ?? '') }}" placeholder="e.g. 30–45 mins">
    </div>

    <div class="col-md-6">
        <label class="form-label">Treatment Category</label>
        <select name="treatment_category_id" class="form-select">
            <option value="">— Select category —</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" {{ (string) old('treatment_category_id', $treatment->treatment_category_id ?? '') === (string) $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Badge</label>
        <input type="text" name="badge" class="form-control" value="{{ old('badge', $treatment->badge ?? '') }}" placeholder="e.g. Most Popular">
        <div class="form-text">Short label shown on the card (optional).</div>
    </div>

    <div class="col-12">
        <label class="form-label">Images <span class="text-muted small">(drop multiple)</span></label>

        @if (isset($treatment) && $treatment->images->isNotEmpty())
            <div class="ltc-gallery-grid mb-2">
                @foreach ($treatment->images as $img)
                    <div class="ltc-gallery-thumb" data-existing-thumb data-id="{{ $img->id }}">
                        <img src="{{ $img->image_url }}" alt="">
                        <button type="button" class="ltc-gallery-x" data-remove-existing title="Remove image">&times;</button>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="img-dropzone ltc-multi-dropzone" data-multi-dropzone tabindex="0" role="button" aria-label="Upload images" style="min-height: 150px;">
            <input type="file" name="images[]" class="d-none" data-multi-input accept="image/png,image/jpeg,image/webp" multiple>
            <div class="img-dropzone-prompt" data-multi-prompt>
                <i class="bi bi-images"></i>
                <div class="fw-semibold">Drag &amp; drop images here</div>
                <div class="small text-muted">or click to browse — you can select several at once</div>
            </div>
        </div>
        <div class="ltc-gallery-grid mt-2" data-multi-preview></div>
        <div data-remove-images-container></div>
        <div class="form-text">Recommended <strong>800 × 600 px</strong> (landscape, 4:3). JPG, PNG or WEBP, max 4 MB each.</div>
    </div>

    <div class="col-12">
        <label class="form-label">Treatment Description</label>
        <input id="treatment_content" type="hidden" name="description" value="{{ old('description', $treatment->description ?? '') }}">
        <trix-toolbar id="treatment-toolbar"></trix-toolbar>
        <trix-editor input="treatment_content" toolbar="treatment-toolbar" class="trix-content"></trix-editor>
        <div class="form-text">Procedure details, benefits, aftercare tips, etc.</div>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $treatment->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $treatment->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(shown on the website)</span></label>
        </div>
    </div>

    <div class="col-12">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="show_on_home" value="1" id="show_on_home"
                {{ old('show_on_home', $treatment->show_on_home ?? false) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="show_on_home">Show on Home Page</label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.treatments.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
