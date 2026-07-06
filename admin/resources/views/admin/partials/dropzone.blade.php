{{--
    Reusable image drag-and-drop upload zone.
    Params:
      name    – file input name (required)
      value   – current image URL (optional)
      accept  – accept attribute (default image/*)
      prompt  – prompt text (optional)
      height  – min-height in px (default 180)
--}}
@php($dzHeight = $height ?? 180)
<div class="img-dropzone {{ ($value ?? null) ? 'has-image' : '' }}" data-dropzone tabindex="0" role="button"
    aria-label="Upload image" style="min-height: {{ $dzHeight }}px;">
    <input type="file" name="{{ $name }}" class="d-none" data-dropzone-input accept="{{ $accept ?? 'image/png,image/jpeg,image/webp,image/svg+xml' }}">
    <img class="img-dropzone-preview" data-dropzone-preview src="{{ $value ?? '' }}" alt="preview"
        style="max-height: {{ $dzHeight - 20 }}px; {{ ($value ?? null) ? '' : 'display:none;' }}">
    <div class="img-dropzone-prompt" data-dropzone-prompt style="{{ ($value ?? null) ? 'display:none;' : '' }}">
        <i class="bi bi-cloud-arrow-up-fill"></i>
        <div class="fw-semibold">{{ $prompt ?? 'Drag & drop an image here' }}</div>
        <div class="small text-muted">or click to browse</div>
    </div>
    <div class="img-dropzone-overlay"><span><i class="bi bi-arrow-repeat me-1"></i> Change image</span></div>
</div>
