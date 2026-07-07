@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Category Name <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" placeholder="e.g. Cosmetic Dentistry" required>
        @isset($category)
            <div class="form-text">Slug: <code>{{ $category->slug }}</code> <span class="text-muted">(updates automatically from the name)</span></div>
        @endisset
    </div>

    <div class="col-12">
        <label class="form-label">Group <span class="req">*</span></label>
        <select name="group" class="form-select" required>
            @foreach (\App\Models\TreatmentCategory::GROUPS as $value => $label)
                <option value="{{ $value }}" {{ old('group', $category->group ?? \App\Models\TreatmentCategory::DEFAULT_GROUP) === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <div class="form-text">Which top-navbar menu this category appears under — <strong>Dental</strong> or <strong>Skin</strong>.</div>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control" placeholder="A short description of this treatment category.">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label">Image <span class="text-muted small">— recommended 600 × 800 px (portrait)</span></label>
        @include('admin.partials.dropzone', [
            'name' => 'image',
            'value' => isset($category) && $category->image_path ? $category->image_url : null,
            'accept' => 'image/png,image/jpeg,image/webp',
            'prompt' => 'Drag & drop the category image here (600 × 800 px)',
            'height' => 180,
        ])
        <div class="form-text">Shown on the website's treatment category tiles. Recommended size <strong>600 × 800 px</strong> (portrait, 3:4). JPG, PNG or WEBP, max 4 MB.</div>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active</label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.treatment-categories.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
