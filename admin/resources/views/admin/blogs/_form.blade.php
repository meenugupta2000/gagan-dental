@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title <span class="req">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title ?? '') }}" placeholder="e.g. Top 10 Beaches to Visit This Summer" required>
    </div>

    <div class="col-12">
        <label class="form-label">Featured Image</label>
        @include('admin.partials.dropzone', [
            'name' => 'image',
            'value' => isset($blog) && $blog->image_path ? $blog->image_url : null,
            'accept' => 'image/png,image/jpeg,image/webp',
            'prompt' => 'Drag & drop the cover image here',
            'height' => 190,
        ])
        <div class="form-text">Recommended <strong>1600 × 900 px</strong> (landscape, 16:9). JPG, PNG or WEBP, max 4 MB.</div>
    </div>

    <div class="col-12">
        <label class="form-label">Content</label>
        <input id="blog_content" type="hidden" name="content" value="{{ old('content', $blog->content ?? '') }}">
        <trix-toolbar id="blog-toolbar"></trix-toolbar>
        <trix-editor input="blog_content" toolbar="blog-toolbar" class="trix-content"></trix-editor>
        <div class="form-text">Use the toolbar to format the article — headings, bold, lists, links, quotes, etc.</div>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $blog->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $blog->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(visible on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
