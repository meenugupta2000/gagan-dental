@extends('layouts.public')

@section('title', 'Book an Appointment · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Book your dental or aesthetics appointment with ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic') . '.')

@section('content')
<style>

    .appt-section { padding: 70px 0 100px; background: #f6f8fb; }
    .appt-grid { display: grid; grid-template-columns: 1fr; gap: 30px; }
    @media (min-width: 992px) { .appt-grid { grid-template-columns: minmax(0,1fr) 360px; align-items: start; } }

    .appt-card { background: #fff; border: 1px solid #eceff5; border-radius: 18px; box-shadow: 0 10px 30px rgba(13,27,42,.05); padding: 34px clamp(22px,4vw,40px); }
    .appt-card h2 { font-size: 1.4rem; font-weight: 800; color: #14233a; margin: 0 0 20px; }
    .appt-field { margin-bottom: 18px; }
    .appt-field label { display: block; font-size: .85rem; font-weight: 600; color: #41506a; margin-bottom: 6px; }
    .appt-field label .req { color: #2e7d32; }
    .appt-field input, .appt-field textarea, .appt-field select {
        width: 100%; border: 1.5px solid #e3e8f0; border-radius: 10px; padding: 12px 15px;
        font-size: .95rem; outline: none; background: #fff; transition: border-color .2s, box-shadow .2s; font-family: inherit;
    }
    .appt-field select { appearance: auto; -webkit-appearance: auto; cursor: pointer; color: #14233a; }
    .appt-field input:focus, .appt-field textarea:focus, .appt-field select:focus { border-color: #2e7d32; box-shadow: 0 0 0 4px rgba(46, 125, 50,.1); }
    .appt-field .err { color: #e03131; font-size: .8rem; margin-top: 5px; }
    .appt-field input.is-invalid, .appt-field textarea.is-invalid, .appt-field select.is-invalid { border-color: #e03131; box-shadow: 0 0 0 4px rgba(224,49,49,.1); }
    .appt-submit { display: inline-flex; align-items: center; gap: 9px; background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; border: 0; border-radius: 50px; padding: 14px 34px; font-weight: 700; font-size: .98rem; cursor: pointer; box-shadow: 0 10px 24px rgba(46, 125, 50,.28); transition: transform .25s, box-shadow .25s; }
    .appt-submit:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(46, 125, 50,.4); }
    .appt-alert { border-radius: 12px; padding: 14px 18px; margin-bottom: 22px; font-size: .92rem; font-weight: 600; }
    .appt-alert.ok { background: #e7f8f0; color: #157a52; border: 1px solid #b6e6d2; }

    /* The theme applies nice-select to every <select>; keep the native controls
       here so the styled form stays consistent and accessible. */
    #appointmentForm .nice-select { display: none !important; }
    #appointmentForm select { display: block !important; }

    .appt-info { background: #0d1b2a; color: #dfe7f0; border-radius: 18px; padding: 32px 28px; }
    .appt-info h3 { color: #fff; font-size: 1.15rem; font-weight: 700; margin: 0 0 8px; }
    .appt-info .lead { color: #9fb0c3; font-size: .92rem; line-height: 1.6; margin: 0 0 22px; }
    .appt-info-item { display: flex; gap: 13px; align-items: flex-start; margin-bottom: 18px; }
    .appt-info-item .ic { flex: 0 0 auto; width: 40px; height: 40px; border-radius: 10px; background: rgba(46, 125, 50,.15); color: #43a047; display: flex; align-items: center; justify-content: center; }
    .appt-info-item a, .appt-info-item span.tx { color: #dfe7f0; text-decoration: none; font-size: .95rem; line-height: 1.5; word-break: break-word; }
    .appt-info-item a:hover { color: #43a047; }
    .appt-phone-line { display: flex; flex-direction: column; gap: 1px; }
    .appt-phone-label { color: #9fb0c3; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; }
    .appt-phone-line a { font-size: 1.02rem; font-weight: 600; }
    .appt-steps { margin-top: 26px; padding-top: 22px; border-top: 1px solid rgba(255,255,255,.12); }
    .appt-steps h4 { color: #fff; font-size: 1rem; font-weight: 700; margin: 0 0 14px; }
    .appt-step { display: flex; gap: 12px; align-items: flex-start; margin-bottom: 12px; color: #9fb0c3; font-size: .9rem; line-height: 1.55; }
    .appt-step .num { flex: 0 0 auto; width: 24px; height: 24px; border-radius: 50%; background: rgba(46, 125, 50,.2); color: #ff9aa0; font-size: .78rem; font-weight: 800; display: grid; place-items: center; }
</style>

<x-page-hero
    title="Book an Appointment"
    subtitle="Tell us when suits you best and our team will confirm your visit promptly." />

<section class="appt-section">
    <div class="container container-1440">
        <div class="appt-grid">
            <div class="appt-card">
                <h2>Request your appointment</h2>

                @if (session('success'))
                    <div class="appt-alert ok">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('appointment.store') }}" id="appointmentForm" novalidate>
                    @csrf
                    <x-form-shield />
                    <div class="row g-3">
                        <div class="col-md-6 appt-field">
                            <label>Name <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required minlength="2" maxlength="255" autocomplete="name">
                            @error('name')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 appt-field">
                            <label>Phone <span class="req">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required maxlength="30" inputmode="tel" autocomplete="tel">
                            @error('phone')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 appt-field">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email">
                            @error('email')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 appt-field">
                            <label>Treatment</label>
                            <input type="text" name="treatment_name" value="{{ old('treatment_name') }}" maxlength="255"
                                   list="treatmentOptions" placeholder="e.g. Teeth Whitening" autocomplete="off">
                            <datalist id="treatmentOptions">
                                @foreach ($treatments as $t)
                                    <option value="{{ $t->name }}"></option>
                                @endforeach
                            </datalist>
                            @error('treatment_name')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 appt-field">
                            <label>Preferred Date</label>
                            <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ now()->format('Y-m-d') }}">
                            @error('preferred_date')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 appt-field">
                            <label>Preferred Time</label>
                            <select name="preferred_time">
                                <option value="">— Any time —</option>
                                @foreach (['Morning', 'Afternoon', 'Evening'] as $slot)
                                    <option value="{{ $slot }}" {{ old('preferred_time') === $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                            </select>
                            @error('preferred_time')<div class="err">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 appt-field">
                            <label>Message</label>
                            <textarea name="message" rows="4" maxlength="5000" placeholder="Tell us briefly about your concern (optional)">{{ old('message') }}</textarea>
                            @error('message')<div class="err">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <button type="submit" class="appt-submit">Book Appointment
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </form>
            </div>

            <aside class="appt-info">
                <h3>Visit us</h3>
                <p class="lead">Prefer to talk? Call or message us and we'll help you find the right time and treatment.</p>

                @php($deptPhones = collect([
                    ['label' => 'Reception', 'value' => $company->tickets_phone],
                    ['label' => 'Appointments', 'value' => $company->packages_phone],
                    ['label' => 'Emergency', 'value' => $company->visa_phone],
                ])->filter(fn ($d) => filled($d['value']))->values())
                @forelse ($deptPhones as $d)
                <div class="appt-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3 13.3113C12.1046 15.622 6.5045 10.0722 8.70828 7.75274C10.0538 6.33657 8.53383 4.71815 7.69249 3.52856C6.11347 1.29596 2.64707 4.37837 2.75235 6.33915C3.08433 12.5224 9.77308 19.8501 16.2502 19.2109C18.2765 19.011 20.6047 15.3516 18.2805 14.0142C17.1183 13.3454 15.523 12.0241 14.3 13.3113Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <div class="appt-phone-line">
                        <span class="appt-phone-label">{{ $d['label'] }}</span>
                        <a href="tel:{{ preg_replace('/[^0-9+]/','',$d['value']) }}">{{ $d['value'] }}</a>
                    </div>
                </div>
                @empty
                @if ($company->phone)
                <div class="appt-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.3 13.3113C12.1046 15.622 6.5045 10.0722 8.70828 7.75274C10.0538 6.33657 8.53383 4.71815 7.69249 3.52856C6.11347 1.29596 2.64707 4.37837 2.75235 6.33915C3.08433 12.5224 9.77308 19.8501 16.2502 19.2109C18.2765 19.011 20.6047 15.3516 18.2805 14.0142C17.1183 13.3454 15.523 12.0241 14.3 13.3113Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <a href="tel:{{ preg_replace('/[^0-9+]/','',$company->phone) }}">{{ $company->phone }}</a>
                </div>
                @endif
                @endforelse
                @if ($company->email)
                <div class="appt-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.83594 11C1.83594 7.54299 1.83594 5.81451 3.17836 4.74057C4.52079 3.66663 6.6814 3.66663 11.0026 3.66663C15.3238 3.66663 17.4844 3.66663 18.8268 4.74057C20.1693 5.81451 20.1693 7.54299 20.1693 11C20.1693 14.4569 20.1693 16.1854 18.8268 17.2594C17.4844 18.3333 15.3238 18.3333 11.0026 18.3333C6.6814 18.3333 4.52079 18.3333 3.17836 17.2594C1.83594 16.1854 1.83594 14.4569 1.83594 11Z" stroke="currentColor" stroke-width="1.5"/><path d="M18.9434 4.86768L14.5201 8.98251C12.8365 10.3855 11.9947 11.087 10.9991 11.087C10.0034 11.087 9.16162 10.3855 7.47804 8.98251L3.05469 4.86768" stroke="currentColor" stroke-width="1.5"/></svg></span>
                    <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                </div>
                @endif
                @php($addr = collect([$company->address, $company->city, $company->state, $company->country, $company->postal_code])->filter()->join(', '))
                @if ($addr)
                <div class="appt-info-item">
                    <span class="ic"><svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.5132 19.0857C11.206 19.3048 10.794 19.3048 10.4868 19.0857C6.06043 15.9292 1.36177 9.43901 6.11114 4.74951C7.40775 3.46924 9.16632 2.75 11 2.75C12.8337 2.75 14.5923 3.46924 15.8889 4.74951C20.6382 9.43901 15.9396 15.9292 11.5132 19.0857Z" stroke="currentColor" stroke-width="1.5"/><path d="M13 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" stroke="currentColor" stroke-width="1.5"/></svg></span>
                    <span class="tx">{{ $addr }}</span>
                </div>
                @endif

                <div class="appt-steps">
                    <h4>How it works</h4>
                    <div class="appt-step"><span class="num">1</span> Send your appointment request using this form.</div>
                    <div class="appt-step"><span class="num">2</span> Our team calls you to confirm the date and time.</div>
                    <div class="appt-step"><span class="num">3</span> Visit the clinic — we take care of the rest.</div>
                </div>
            </aside>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    var form = document.getElementById('appointmentForm');
    if (!form) return;

    // The theme's bundled JS wraps every <select> with nice-select; remove those
    // wrappers inside this form so the native selects (styled above) are used.
    try {
        if (window.jQuery && jQuery.fn.niceSelect) { jQuery('#appointmentForm select').niceSelect('destroy'); }
    } catch (e) { /* nice-select not initialised — nothing to do */ }

    var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

    var rules = {
        name: function (v) {
            if (!v) return 'Please enter your name.';
            if (v.length < 2) return 'Name must be at least 2 characters.';
            if (!/^[\p{L}][\p{L} .'\-]*$/u.test(v)) return 'Name can only contain letters, spaces, . \' and -';
        },
        phone: function (v) {
            if (!v) return 'Please enter your phone number.';
            if (!/^[0-9+()\-\s]+$/.test(v)) return 'Phone can only contain digits and + - ( ) and spaces.';
            var digits = v.replace(/\D/g, '');
            if (digits.length < 7 || digits.length > 15) return 'Please enter a valid phone number (7–15 digits).';
        },
        email: function (v) {
            if (!v) return; // optional
            if (v.length > 255) return 'Email address is too long.';
            if (!EMAIL_RE.test(v)) return 'Please enter a valid email address (e.g. name@example.com).';
        },
        preferred_date: function (v) {
            if (!v) return; // optional
            var today = new Date(); today.setHours(0, 0, 0, 0);
            var picked = new Date(v + 'T00:00:00');
            if (isNaN(picked.getTime())) return 'Please pick a valid date.';
            if (picked < today) return 'Please pick today or a later date.';
        },
        message: function (v) {
            if (v && v.length > 5000) return 'Message is too long (max 5000 characters).';
        }
    };

    function fieldOf(name) { return form.querySelector('[name="' + name + '"]'); }
    function wrapOf(input) { return input.closest('.appt-field'); }

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
