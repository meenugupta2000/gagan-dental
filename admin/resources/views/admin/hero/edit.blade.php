@extends('layouts.admin')

@section('title', 'Hero Section')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1">Hero Section</h2>
    <p>Manage the main banner on your home page and the top banner shown across inner pages.</p>
</div>

<form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        {{-- Content --}}
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-card-text"></i></span> Content</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Punchline <span class="req">*</span></label>
                            <textarea name="punchline" rows="3" class="form-control" required
                                placeholder="Brighter Smiles,&#10;Healthier Lives">{{ old('punchline', $hero->punchline) }}</textarea>
                            <div class="form-text">The main heading. Each new line is shown as a separate line on the website.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control"
                                placeholder="A short supporting sentence shown under the punchline.">{{ old('description', $hero->description) }}</textarea>
                            <div class="form-text">Appears just below the punchline.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Home page background image --}}
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-image"></i></span> Home Page Background</div>
                <div class="card-body">
                    <label class="form-label">Home Hero Background Image</label>
                    <div class="hero-dropzone {{ $hero->image_path ? 'has-image' : '' }}" data-hero-dropzone tabindex="0" role="button" aria-label="Upload home background image">
                        <input type="file" name="image" class="d-none" accept="image/png,image/jpeg,image/webp" data-hero-input>
                        <img class="hero-dropzone-preview {{ $hero->image_path ? '' : 'd-none' }}" src="{{ $hero->image_url ?? '' }}" alt="Home hero background" data-hero-preview>
                        <div class="hero-dropzone-prompt {{ $hero->image_path ? 'd-none' : '' }}" data-hero-prompt>
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                            <div class="fw-semibold mt-1">Drag &amp; drop an image here</div>
                            <div class="small text-muted">or click to browse</div>
                        </div>
                        <div class="hero-dropzone-overlay"><span><i class="bi bi-arrow-repeat me-1"></i> Change image</span></div>
                    </div>
                    <div class="form-text" data-hero-filename></div>
                    <div class="form-text">
                        Shown only on the <strong>home page</strong> hero. Recommended:
                        <strong>{{ \App\Models\HeroSection::RECOMMENDED_RESOLUTION }}</strong> (landscape). JPG, PNG or WEBP, max 4 MB.
                    </div>
                </div>
            </div>
        </div>

        {{-- Inner page banner --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-images"></i></span> Inner Page Banner</div>
                <div class="card-body">
                    <div class="row g-3 align-items-start">
                        <div class="col-lg-6">
                            <label class="form-label">Inner Page Top Banner</label>
                            <div class="hero-dropzone hero-dropzone--wide {{ $hero->inner_banner_path ? 'has-image' : '' }}" data-hero-dropzone tabindex="0" role="button" aria-label="Upload inner page banner">
                                <input type="file" name="inner_banner" class="d-none" accept="image/png,image/jpeg,image/webp" data-hero-input>
                                <img class="hero-dropzone-preview {{ $hero->inner_banner_path ? '' : 'd-none' }}" src="{{ $hero->inner_banner_url ?? '' }}" alt="Inner page banner" data-hero-preview>
                                <div class="hero-dropzone-prompt {{ $hero->inner_banner_path ? 'd-none' : '' }}" data-hero-prompt>
                                    <i class="bi bi-cloud-arrow-up-fill"></i>
                                    <div class="fw-semibold mt-1">Drag &amp; drop an image here</div>
                                    <div class="small text-muted">or click to browse</div>
                                </div>
                                <div class="hero-dropzone-overlay"><span><i class="bi bi-arrow-repeat me-1"></i> Change image</span></div>
                            </div>
                            <div class="form-text" data-hero-filename></div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-muted small">
                                <p class="mb-2">This banner appears at the <strong>top of the inner pages</strong>:</p>
                                <p class="mb-2"><span class="badge text-bg-light me-1">Treatments</span><span class="badge text-bg-light me-1">Testimonials</span><span class="badge text-bg-light me-1">Offers</span><span class="badge text-bg-light me-1">FAQs</span><span class="badge text-bg-light me-1">Blog</span><span class="badge text-bg-light me-1">Appointment</span><span class="badge text-bg-light me-1">Contact</span><span class="badge text-bg-light me-1">About</span></p>
                                <p class="mb-0">Recommended: <strong>{{ \App\Models\HeroSection::RECOMMENDED_BANNER_RESOLUTION }}</strong> (wide &amp; short). JPG, PNG or WEBP, max 4 MB. If left empty, the default theme image is used.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-brand">
            <i class="bi bi-save me-1"></i> Save Hero Section
        </button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Cancel</a>
    </div>
</form>

@push('styles')
<style>
    .hero-dropzone {
        position: relative;
        min-height: 200px;
        border: 2px dashed var(--ltc-border-strong);
        border-radius: var(--ltc-radius-sm);
        background: var(--ltc-input-bg);
        display: flex; align-items: center; justify-content: center;
        text-align: center; cursor: pointer; overflow: hidden;
        transition: border-color .15s ease, background .15s ease;
    }
    .hero-dropzone:hover, .hero-dropzone:focus { border-color: var(--ltc-brand); outline: none; }
    .hero-dropzone.is-dragover { border-color: var(--ltc-brand); background: var(--ltc-brand-soft); }
    .hero-dropzone-prompt { padding: 1.25rem; color: var(--ltc-text-muted); }
    .hero-dropzone-prompt i { font-size: 2.2rem; color: var(--ltc-brand); }
    .hero-dropzone-preview { width: 100%; height: 200px; object-fit: cover; display: block; }
    .hero-dropzone--wide { min-height: 160px; }
    .hero-dropzone--wide .hero-dropzone-preview { height: 160px; }
    .hero-dropzone-overlay {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        background: rgba(13, 27, 42, .5); color: #fff; font-weight: 600;
        opacity: 0; transition: opacity .15s ease; pointer-events: none;
    }
    .hero-dropzone.has-image:hover .hero-dropzone-overlay,
    .hero-dropzone.is-dragover .hero-dropzone-overlay { opacity: 1; }
</style>
@endpush

@push('scripts')
<script>
    (function () {
        document.querySelectorAll('[data-hero-dropzone]').forEach(function (zone) {
            var input = zone.querySelector('[data-hero-input]');
            var preview = zone.querySelector('[data-hero-preview]');
            var prompt = zone.querySelector('[data-hero-prompt]');
            var nameEl = zone.parentElement.querySelector('[data-hero-filename]');
            if (!input) return;

            zone.addEventListener('click', function () { input.click(); });
            zone.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
            });

            ['dragenter', 'dragover'].forEach(function (ev) {
                zone.addEventListener(ev, function (e) { e.preventDefault(); e.stopPropagation(); zone.classList.add('is-dragover'); });
            });
            ['dragleave', 'dragend'].forEach(function (ev) {
                zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.remove('is-dragover'); });
            });
            zone.addEventListener('drop', function (e) {
                e.preventDefault(); e.stopPropagation();
                zone.classList.remove('is-dragover');
                var files = e.dataTransfer && e.dataTransfer.files;
                if (!files || !files.length) return;
                try {
                    var dt = new DataTransfer();
                    dt.items.add(files[0]);
                    input.files = dt.files;
                } catch (err) {
                    input.files = files;
                }
                handleFile(files[0]);
            });

            input.addEventListener('change', function () {
                if (input.files && input.files[0]) handleFile(input.files[0]);
            });

            function handleFile(file) {
                if (!/^image\/(png|jpe?g|webp)$/i.test(file.type)) {
                    if (nameEl) nameEl.innerHTML = '<span class="text-danger">Unsupported file type — please use JPG, PNG or WEBP.</span>';
                    input.value = '';
                    if (preview) preview.classList.add('d-none');
                    if (prompt) prompt.classList.remove('d-none');
                    zone.classList.remove('has-image');
                    return;
                }
                if (preview) { preview.src = URL.createObjectURL(file); preview.classList.remove('d-none'); }
                if (prompt) prompt.classList.add('d-none');
                zone.classList.add('has-image');
                if (nameEl) nameEl.textContent = file.name + ' · ' + Math.round(file.size / 1024) + ' KB';
            }
        });
    })();
</script>
@endpush
@endsection
