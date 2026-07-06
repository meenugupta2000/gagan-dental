@extends('layouts.public')

@section('title', 'Contact Us · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Get in touch with ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic') . '.')

@section('content')
<style>

    .contact-section { padding: 70px 0 100px; background: #f6f8fb; }
    .contact-grid { display: grid; grid-template-columns: 1fr; gap: 30px; }
    @media (min-width: 992px) { .contact-grid { grid-template-columns: minmax(0,1fr) 360px; align-items: start; } }

    .contact-card { background: #fff; border: 1px solid #eceff5; border-radius: 18px; box-shadow: 0 10px 30px rgba(13,27,42,.05); padding: 34px clamp(22px,4vw,40px); }
    .contact-card h2 { font-size: 1.4rem; font-weight: 800; color: #14233a; margin: 0 0 20px; }
    .contact-field { margin-bottom: 18px; }
    .contact-field label { display: block; font-size: .85rem; font-weight: 600; color: #41506a; margin-bottom: 6px; }
    .contact-field label .req { color: #2e7d32; }
    .contact-field input, .contact-field textarea {
        width: 100%; border: 1.5px solid #e3e8f0; border-radius: 10px; padding: 12px 15px;
        font-size: .95rem; outline: none; background: #fff; transition: border-color .2s, box-shadow .2s; font-family: inherit;
    }
    .contact-field input:focus, .contact-field textarea:focus { border-color: #2e7d32; box-shadow: 0 0 0 4px rgba(46, 125, 50,.1); }
    .contact-field .err { color: #e03131; font-size: .8rem; margin-top: 5px; }
    .contact-field input.is-invalid, .contact-field textarea.is-invalid { border-color: #e03131; box-shadow: 0 0 0 4px rgba(224,49,49,.1); }
    .contact-captcha { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .contact-captcha .q { background: #f1f4f9; border: 1.5px dashed #d7deea; border-radius: 10px; padding: 11px 16px; font-weight: 700; color: #14233a; white-space: nowrap; }
    .contact-captcha input { max-width: 130px; }
    .contact-submit { display: inline-flex; align-items: center; gap: 9px; background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; border: 0; border-radius: 50px; padding: 14px 34px; font-weight: 700; font-size: .98rem; cursor: pointer; box-shadow: 0 10px 24px rgba(46, 125, 50,.28); transition: transform .25s, box-shadow .25s; }
    .contact-submit:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(46, 125, 50,.4); }
    .contact-alert { border-radius: 12px; padding: 14px 18px; margin-bottom: 22px; font-size: .92rem; font-weight: 600; }
    .contact-alert.ok { background: #e7f8f0; color: #157a52; border: 1px solid #b6e6d2; }

    .contact-info { background: #0d1b2a; color: #dfe7f0; border-radius: 18px; padding: 32px 28px; }
    .contact-info h3 { color: #fff; font-size: 1.15rem; font-weight: 700; margin: 0 0 8px; }
    .contact-info .lead { color: #9fb0c3; font-size: .92rem; line-height: 1.6; margin: 0 0 14px; }
    .contact-parent { color: #9fb0c3; font-size: .9rem; margin: 0 0 22px; }
    .contact-parent strong { color: #fff; font-weight: 700; }
    .contact-info-item { display: flex; gap: 13px; align-items: flex-start; margin-bottom: 18px; }
    .contact-info-item .ic { flex: 0 0 auto; width: 40px; height: 40px; border-radius: 10px; background: rgba(46, 125, 50,.15); color: #43a047; display: flex; align-items: center; justify-content: center; }
    .contact-info-item a, .contact-info-item span { color: #dfe7f0; text-decoration: none; font-size: .95rem; line-height: 1.5; word-break: break-word; }
    .contact-info-item a:hover { color: #43a047; }
    .contact-phone-line { display: flex; flex-direction: column; gap: 1px; }
    .contact-phone-label { color: #9fb0c3 !important; font-size: .72rem !important; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; }
    .contact-phone-line a { font-size: 1.02rem !important; font-weight: 600; }
    .contact-divisions { margin-top: 26px; padding-top: 22px; border-top: 1px solid rgba(255,255,255,.12); }
    .contact-div-title { color: #fff; font-size: 1rem; font-weight: 700; margin: 0 0 16px; }
    .contact-book-btn {
        display: inline-flex; align-items: center; gap: 9px;
        background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff;
        border-radius: 50px; padding: 12px 26px; font-weight: 700; font-size: .95rem; text-decoration: none;
        box-shadow: 0 10px 24px rgba(46, 125, 50,.28); transition: transform .25s, box-shadow .25s;
    }
    .contact-book-btn:hover { color: #fff; transform: translateY(-3px); box-shadow: 0 16px 32px rgba(46, 125, 50,.4); }
    .contact-map-full { margin-top: 40px; border-radius: 18px; overflow: hidden; border: 1px solid #eceff5; box-shadow: 0 10px 30px rgba(13,27,42,.06); }
    .contact-map-full iframe { width: 100%; height: 420px; border: 0; display: block; }
</style>

<x-page-hero
    title="Contact Us"
    subtitle="We'd love to hear from you. Send us a message and we'll respond as soon as we can." />

<section class="contact-section">
    <div class="container container-1440">
        <div class="contact-grid">
            <div class="contact-card">
                <h2>Send us a message</h2>

                @if (session('success'))
                    <div class="contact-alert ok"><i class="bi"></i> {{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" id="contactForm" novalidate>
                    @csrf
                    <x-form-shield />
                    <div class="row g-3">
                        <div class="col-md-6 contact-field">
                            <label>Name <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required minlength="2" maxlength="255" autocomplete="name">
                            @error('name')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 contact-field">
                            <label>Email <span class="req">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email">
                            @error('email')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 contact-field">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" maxlength="30" inputmode="tel" autocomplete="tel">
                            @error('phone')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 contact-field">
                            <label>Subject</label>
                            <input type="text" name="subject" value="{{ old('subject', request('subject')) }}" maxlength="255">
                            @error('subject')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 contact-field">
                            <label>Message <span class="req">*</span></label>
                            <textarea name="message" rows="5" required minlength="10" maxlength="5000">{{ old('message') }}</textarea>
                            @error('message')<div class="err">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <button type="submit" class="contact-submit">Send Message
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </form>
            </div>

            <aside class="contact-info">
                <h3>Get in touch</h3>
                <p class="lead">We're happy to answer any questions about your dental care, aesthetic treatments or appointments.</p>
                @if ($company->parent_company)
                <p class="contact-parent">A unit of <strong>{{ $company->parent_company }}</strong></p>
                @endif

                @php($deptPhones = collect([
                    ['label' => 'Reception', 'value' => $company->tickets_phone],
                    ['label' => 'Appointments', 'value' => $company->packages_phone],
                    ['label' => 'Emergency', 'value' => $company->visa_phone],
                ])->filter(fn ($d) => filled($d['value']))->values())
                @forelse ($deptPhones as $d)
                <div class="contact-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3 13.3113C12.1046 15.622 6.5045 10.0722 8.70828 7.75274C10.0538 6.33657 8.53383 4.71815 7.69249 3.52856C6.11347 1.29596 2.64707 4.37837 2.75235 6.33915C3.08433 12.5224 9.77308 19.8501 16.2502 19.2109C18.2765 19.011 20.6047 15.3516 18.2805 14.0142C17.1183 13.3454 15.523 12.0241 14.3 13.3113Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <div class="contact-phone-line">
                        <span class="contact-phone-label">{{ $d['label'] }}</span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/','',$d['value']) }}">{{ $d['value'] }}</a>
                    </div>
                </div>
                @empty
                @if ($company->phone)
                <div class="contact-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3 13.3113C12.1046 15.622 6.5045 10.0722 8.70828 7.75274C10.0538 6.33657 8.53383 4.71815 7.69249 3.52856C6.11347 1.29596 2.64707 4.37837 2.75235 6.33915C3.08433 12.5224 9.77308 19.8501 16.2502 19.2109C18.2765 19.011 20.6047 15.3516 18.2805 14.0142C17.1183 13.3454 15.523 12.0241 14.3 13.3113Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <a href="tel:{{ preg_replace('/[^0-9+]/','',$company->phone) }}">{{ $company->phone }}</a>
                </div>
                @endif
                @endforelse
                @if ($company->email)
                <div class="contact-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.83594 11C1.83594 7.54299 1.83594 5.81451 3.17836 4.74057C4.52079 3.66663 6.6814 3.66663 11.0026 3.66663C15.3238 3.66663 17.4844 3.66663 18.8268 4.74057C20.1693 5.81451 20.1693 7.54299 20.1693 11C20.1693 14.4569 20.1693 16.1854 18.8268 17.2594C17.4844 18.3333 15.3238 18.3333 11.0026 18.3333C6.6814 18.3333 4.52079 18.3333 3.17836 17.2594C1.83594 16.1854 1.83594 14.4569 1.83594 11Z" stroke="currentColor" stroke-width="1.5"/><path d="M18.9434 4.86768L14.5201 8.98251C12.8365 10.3855 11.9947 11.087 10.9991 11.087C10.0034 11.087 9.16162 10.3855 7.47804 8.98251L3.05469 4.86768" stroke="currentColor" stroke-width="1.5"/></svg></span>
                    <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                </div>
                @endif
                @php($addr = collect([$company->address, $company->city, $company->state, $company->country, $company->postal_code])->filter()->join(', '))
                @if ($addr)
                <div class="contact-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.5132 19.0857C11.206 19.3048 10.794 19.3048 10.4868 19.0857C6.06043 15.9292 1.36177 9.43901 6.11114 4.74951C7.40775 3.46924 9.16632 2.75 11 2.75C12.8337 2.75 14.5923 3.46924 15.8889 4.74951C20.6382 9.43901 15.9396 15.9292 11.5132 19.0857Z" stroke="currentColor" stroke-width="1.5"/><path d="M13 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" stroke="currentColor" stroke-width="1.5"/></svg></span>
                    <span>{{ $addr }}</span>
                </div>
                @endif

                <div class="contact-divisions">
                    <h4 class="contact-div-title">Need an appointment?</h4>
                    <p class="lead" style="margin-bottom:14px;">Skip the message and book your visit directly — it only takes a minute.</p>
                    <a href="{{ route('appointment') }}" class="contact-book-btn">Book an Appointment
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

            </aside>
        </div>

        @if ($company->map_embed)
        <div class="contact-map-full">
            @if (\Illuminate\Support\Str::startsWith(trim($company->map_embed), '<'))
                {!! $company->map_embed !!}
            @else
                <iframe src="{{ $company->map_embed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
            @endif
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
(function () {
    var form = document.getElementById('contactForm');
    if (!form) return;

    var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    var rules = {
        name: function (v) {
            if (!v) return 'Please enter your name.';
            if (v.length < 2) return 'Name must be at least 2 characters.';
            if (!/^[\p{L}][\p{L} .'\-]*$/u.test(v)) return 'Name can only contain letters, spaces, . \' and -';
        },
        email: function (v) {
            if (!v) return 'Please enter your email address.';
            if (v.length > 255) return 'Email address is too long.';
            if (!EMAIL_RE.test(v)) return 'Please enter a valid email address (e.g. name@example.com).';
        },
        phone: function (v) {
            if (!v) return; // optional
            if (!/^[0-9+()\-\s]+$/.test(v)) return 'Phone can only contain digits and + - ( ) and spaces.';
            var digits = v.replace(/\D/g, '');
            if (digits.length < 7 || digits.length > 15) return 'Please enter a valid phone number (7–15 digits).';
        },
        subject: function (v) {
            if (v && v.length > 255) return 'Subject is too long.';
        },
        message: function (v) {
            if (!v) return 'Please enter your message.';
            if (v.length < 10) return 'Message must be at least 10 characters.';
            if (v.length > 5000) return 'Message is too long (max 5000 characters).';
        }
    };

    function fieldOf(name) { return form.querySelector('[name="' + name + '"]'); }
    function wrapOf(input) { return input.closest('.contact-field'); }

    function clearError(input) {
        input.classList.remove('is-invalid');
        var wrap = wrapOf(input);
        if (!wrap) return;
        var e = wrap.querySelector('.err.js-err');
        if (e) e.remove();
    }

    function showError(input, msg) {
        input.classList.add('is-invalid');
        var wrap = wrapOf(input);
        if (!wrap) return;
        var e = wrap.querySelector('.err.js-err');
        if (!e) { e = document.createElement('div'); e.className = 'err js-err'; wrap.appendChild(e); }
        e.textContent = msg;
    }

    function validateField(name) {
        var input = fieldOf(name);
        if (!input) return true;
        var msg = rules[name](input.value.trim());
        if (msg) { showError(input, msg); return false; }
        clearError(input);
        return true;
    }

    // Live: clear an error as the user fixes it.
    Object.keys(rules).forEach(function (name) {
        var input = fieldOf(name);
        if (!input) return;
        input.addEventListener('input', function () {
            if (input.classList.contains('is-invalid')) validateField(name);
        });
        input.addEventListener('blur', function () { validateField(name); });
    });

    form.addEventListener('submit', function (e) {
        var firstInvalid = null;
        Object.keys(rules).forEach(function (name) {
            var ok = validateField(name);
            if (!ok && !firstInvalid) firstInvalid = fieldOf(name);
        });
        if (firstInvalid) {
            e.preventDefault();
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>
@endpush
@endsection
