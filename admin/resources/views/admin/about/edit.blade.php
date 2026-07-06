@extends('layouts.admin')

@section('title', 'About Section')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1">About Section</h2>
    <p>The home "Get to know us" block <span class="text-muted">and</span> the full public <a href="{{ route('about') }}" target="_blank">About page</a>.</p>
</div>

<form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="max-width: 900px;">

        {{-- Home "Get to know us" block --}}
        <div class="card mb-4">
            <div class="card-header"><span class="sec-icon"><i class="bi bi-house-heart"></i></span> Home Page — "Get to know us" block</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Subtitle <span class="text-muted small">(small eyebrow text)</span></label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $about->subtitle) }}" placeholder="Get To Know Us">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Title <span class="req">*</span></label>
                        <textarea name="title" rows="2" class="form-control" required
                            placeholder="Complete Dental &#38; Aesthetic Care You Can Trust">{{ old('title', $about->title) }}</textarea>
                        <div class="form-text">Each new line is shown as a separate line on the website.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control"
                            placeholder="A short supporting paragraph.">{{ old('description', $about->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- About page — Doctor profile --}}
        <div class="card mb-4">
            <div class="card-header"><span class="sec-icon"><i class="bi bi-person-badge"></i></span> About Page — Doctor Profile</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Doctor Name</label>
                        <input type="text" name="doctor_name" class="form-control" value="{{ old('doctor_name', $about->doctor_name) }}" placeholder="Dr. Gaganpreet Kaur">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Doctor Title / Specialty</label>
                        <input type="text" name="doctor_title" class="form-control" value="{{ old('doctor_title', $about->doctor_title) }}" placeholder="The Smile Design Specialist">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Years of Experience</label>
                        <input type="number" name="experience_years" class="form-control" min="0" max="100" value="{{ old('experience_years', $about->experience_years) }}" placeholder="18">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Clinic Established / Since</label>
                        <input type="text" name="clinic_since" class="form-control" value="{{ old('clinic_since', $about->clinic_since) }}" placeholder="2008">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Doctor Photo</label>
                        @include('admin.partials.dropzone', [
                            'name' => 'doctor_photo',
                            'value' => $about->doctor_photo_url,
                            'accept' => 'image/png,image/jpeg,image/webp',
                            'prompt' => 'Drag & drop the doctor photo here',
                            'height' => 200,
                        ])
                        <div class="form-text">Recommended <strong>800 × 1000 px</strong> (portrait). JPG, PNG or WEBP, max 4 MB.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- About page — Content --}}
        <div class="card mb-4">
            <div class="card-header"><span class="sec-icon"><i class="bi bi-card-text"></i></span> About Page — Content</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Intro <span class="text-muted small">(lead paragraph under the hero)</span></label>
                        <textarea name="intro" rows="3" class="form-control" placeholder="A compelling one or two sentence introduction.">{{ old('intro', $about->intro) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Main Content</label>
                        <input id="about_body" type="hidden" name="body" value="{{ old('body', $about->body ?? '') }}">
                        <trix-toolbar id="about-toolbar"></trix-toolbar>
                        <trix-editor input="about_body" toolbar="about-toolbar" class="trix-content"></trix-editor>
                        <div class="form-text">The doctor's story, background and clinic philosophy — use headings, bold, lists and quotes to make room for as much as you like.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Qualifications <span class="text-muted small">(one per line)</span></label>
                        <textarea name="qualifications" rows="5" class="form-control" placeholder="Oro Dental &#38; Aesthetic Expert&#10;Cosmetologist&#10;FMC — Cosmetology&#10;FAM (USA)">{{ old('qualifications', $about->qualifications) }}</textarea>
                        <div class="form-text">Each line becomes a bullet in the credentials list.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Philosophy / Promise</label>
                        <textarea name="philosophy" rows="5" class="form-control" placeholder="A short mission statement or quote shown in a highlighted panel.">{{ old('philosophy', $about->philosophy) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- About page — Stats --}}
        <div class="card mb-4">
            <div class="card-header"><span class="sec-icon"><i class="bi bi-bar-chart"></i></span> About Page — Headline Stats <span class="text-muted small ms-1">(shown as a stats band; leave blank to hide)</span></div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach ([1, 2, 3, 4] as $i)
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <div style="width: 40%;">
                                    <label class="form-label">Stat {{ $i }} Value</label>
                                    <input type="text" name="stat{{ $i }}_value" class="form-control" value="{{ old("stat{$i}_value", $about->{"stat{$i}_value"}) }}" placeholder="{{ ['18+','2008','10,000+','100%'][$i-1] }}">
                                </div>
                                <div style="flex: 1;">
                                    <label class="form-label">Stat {{ $i }} Label</label>
                                    <input type="text" name="stat{{ $i }}_label" class="form-control" value="{{ old("stat{$i}_label", $about->{"stat{$i}_label"}) }}" placeholder="{{ ['Years of Experience','Trusted Since','Smiles Created','Personalised Care'][$i-1] }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <div class="mt-2 d-flex gap-2">
        <button type="submit" class="btn btn-brand"><i class="bi bi-save me-1"></i> Save About Section</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Cancel</a>
    </div>
</form>
@endsection
