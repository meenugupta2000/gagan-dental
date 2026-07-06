@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Title <span class="req">*</span></label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $page->title ?? '') }}" placeholder="e.g. Privacy Policy" required>
        @isset($page)<div class="form-text">URL slug: <code>/page/{{ $page->slug }}</code> (stays fixed)</div>@endisset
    </div>

    <div class="col-12">
        <label class="form-label">Content</label>
        <input id="page_content" type="hidden" name="content" value="{{ old('content', $page->content ?? '') }}">
        <trix-toolbar id="page-toolbar"></trix-toolbar>
        <trix-editor input="page_content" toolbar="page-toolbar" class="trix-content"></trix-editor>
        <div class="form-text">Use the toolbar to format the page — headings, bold, lists, links, etc.</div>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(visible on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-light">Cancel</a>
</div>
