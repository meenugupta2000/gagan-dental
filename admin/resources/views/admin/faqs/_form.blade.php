@csrf
<div class="row g-3">
    <div class="col-12">
        <label class="form-label">Question <span class="req">*</span></label>
        <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question ?? '') }}" placeholder="e.g. How often should I visit the dentist?" required>
    </div>

    <div class="col-12">
        <label class="form-label">Answer <span class="req">*</span></label>
        <textarea name="answer" rows="4" class="form-control" placeholder="A clear, friendly answer for patients." required>{{ old('answer', $faq->answer ?? '') }}</textarea>
    </div>

    <div class="col-6">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $faq->sort_order ?? 0) }}">
        <div class="form-text">Lower numbers appear first.</div>
    </div>

    <div class="col-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label ms-1" for="is_active">Active <span class="text-muted small">(visible on the website)</span></label>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4 pt-2">
    <button type="submit" class="btn btn-brand">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-light" data-drawer-cancel>Cancel</a>
</div>
