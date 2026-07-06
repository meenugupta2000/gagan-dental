@extends('layouts.admin')

@section('title', 'Company Info')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1">Company Information</h2>
    <p>This profile powers your website's contact details, branding and social links.</p>
</div>

<form method="POST" action="{{ route('admin.company.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @php($val = fn($field) => old($field, $company->$field))

    <div class="row g-4">
        {{-- Basic details --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-info-circle"></i></span> Basic Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Company Name <span class="req">*</span></label>
                            <input type="text" name="company_name" class="form-control" value="{{ $val('company_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tagline</label>
                            <input type="text" name="tagline" class="form-control" value="{{ $val('tagline') }}" placeholder="Healthy Smiles, Confident You">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Parent Company</label>
                            <input type="text" name="parent_company" class="form-control" value="{{ $val('parent_company') }}" placeholder="e.g. ABC Holdings Pvt Ltd">
                        </div>
                        <div class="col-12">
                            <label class="form-label">About</label>
                            <textarea name="about" rows="3" class="form-control" placeholder="A short description of the company.">{{ $val('about') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-telephone"></i></span> Contact</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $val('email') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $val('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ $val('whatsapp') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Website</label>
                            <input type="text" name="website" class="form-control" value="{{ $val('website') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Link</label>
                            <input type="url" name="payment_url" class="form-control" value="{{ $val('payment_url') }}" placeholder="https://payments.example.com">
                            <div class="form-text">Shown as a <strong>“Payment”</strong> link in the website navbar (opens in a new tab). Leave blank to hide it.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Division contacts --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-headset"></i></span> Department Contacts</div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Separate phone &amp; email for each department — shown on the website's Contact page.</p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Reception — Phone</label>
                            <input type="text" name="tickets_phone" class="form-control" value="{{ $val('tickets_phone') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Appointments — Phone</label>
                            <input type="text" name="packages_phone" class="form-control" value="{{ $val('packages_phone') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Emergency — Phone</label>
                            <input type="text" name="visa_phone" class="form-control" value="{{ $val('visa_phone') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reception — Email</label>
                            <input type="email" name="tickets_email" class="form-control" value="{{ $val('tickets_email') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Appointments — Email</label>
                            <input type="email" name="packages_email" class="form-control" value="{{ $val('packages_email') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Emergency — Email</label>
                            <input type="email" name="visa_email" class="form-control" value="{{ $val('visa_email') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-geo-alt"></i></span> Address</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Street Address</label>
                            <textarea name="address" rows="2" class="form-control">{{ $val('address') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $val('city') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="{{ $val('state') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ $val('country') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" value="{{ $val('postal_code') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Branding --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-image"></i></span> Branding</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Logo</label>
                            @include('admin.partials.dropzone', [
                                'name' => 'logo',
                                'value' => $company->logo_path ? asset('storage/'.$company->logo_path) : null,
                                'prompt' => 'Drag & drop your logo',
                                'accept' => 'image/png,image/jpeg,image/svg+xml,image/webp',
                                'height' => 150,
                            ])
                            <div class="form-text">Recommended <strong>240 × 80 px</strong> (transparent). PNG, JPG, SVG or WEBP. Max 2 MB.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Favicon</label>
                            @include('admin.partials.dropzone', [
                                'name' => 'favicon',
                                'value' => $company->favicon_path ? asset('storage/'.$company->favicon_path) : null,
                                'prompt' => 'Drag & drop your favicon',
                                'accept' => 'image/png,image/x-icon,image/svg+xml',
                                'height' => 150,
                            ])
                            <div class="form-text">Recommended <strong>64 × 64 px</strong> (square). PNG, ICO or SVG. Max 1 MB.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Treatments Menu Image</label>
                            @include('admin.partials.dropzone', [
                                'name' => 'menu_image',
                                'value' => $company->menu_image_path ? asset('storage/'.$company->menu_image_path) : null,
                                'prompt' => 'Drag & drop the menu promo image',
                                'accept' => 'image/png,image/jpeg,image/webp',
                                'height' => 150,
                            ])
                            <div class="form-text">Shown as the promo image on the right of the <strong>Treatments</strong> mega-menu. Recommended <strong>500 × 600 px</strong> (portrait). JPG, PNG or WEBP, max 2 MB.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Home Banner Image</label>
                            @include('admin.partials.dropzone', [
                                'name' => 'cta_image',
                                'value' => $company->cta_image_path ? asset('storage/'.$company->cta_image_path) : null,
                                'prompt' => 'Drag & drop the home banner image',
                                'accept' => 'image/png,image/jpeg,image/webp',
                                'height' => 150,
                            ])
                            <div class="form-text">Background of the home page <strong>call-to-action</strong> banner. Recommended <strong>1920 × 900 px</strong> (wide landscape). JPG, PNG or WEBP, max 4 MB.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legal --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-receipt"></i></span> Legal</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">GSTIN</label>
                            <input type="text" name="gst_number" class="form-control" value="{{ $val('gst_number') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">CIN</label>
                            <input type="text" name="registration_number" class="form-control" value="{{ $val('registration_number') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">License No.</label>
                            <input type="text" name="license_no" class="form-control" value="{{ $val('license_no') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Social links --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-share"></i></span> Social Links</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label"><i class="bi bi-facebook text-primary me-1"></i> Facebook</label><input type="url" name="facebook_url" class="form-control" value="{{ $val('facebook_url') }}"></div>
                        <div class="col-md-4"><label class="form-label"><i class="bi bi-instagram me-1" style="color:#d6336c;"></i> Instagram</label><input type="url" name="instagram_url" class="form-control" value="{{ $val('instagram_url') }}"></div>
                        <div class="col-md-4"><label class="form-label"><i class="bi bi-twitter-x me-1"></i> Twitter / X</label><input type="url" name="twitter_url" class="form-control" value="{{ $val('twitter_url') }}"></div>
                        <div class="col-md-4"><label class="form-label"><i class="bi bi-linkedin text-primary me-1"></i> LinkedIn</label><input type="url" name="linkedin_url" class="form-control" value="{{ $val('linkedin_url') }}"></div>
                        <div class="col-md-4"><label class="form-label"><i class="bi bi-youtube text-danger me-1"></i> YouTube</label><input type="url" name="youtube_url" class="form-control" value="{{ $val('youtube_url') }}"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Map --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-map"></i></span> Google Map Embed</div>
                <div class="card-body">
                    <label class="form-label">Map Embed Code / URL</label>
                    <textarea name="map_embed" rows="2" class="form-control" placeholder="<iframe src=...></iframe>">{{ $val('map_embed') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Live chat & WhatsApp --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-chat-dots"></i></span> Live Chat &amp; WhatsApp</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label"><i class="bi bi-headset me-1"></i> Tawk.to Embed URL</label>
                            <input type="text" name="tawkto_src" class="form-control" value="{{ $val('tawkto_src') }}" placeholder="https://embed.tawk.to/XXXXXXXX/YYYYYYYY">
                            <div class="form-text">From Tawk.to → Admin → Channels → Chat Widget, copy the <code>src</code> URL from the embed code. Leave blank to hide the chat widget.</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label"><i class="bi bi-whatsapp me-1 text-success"></i> WhatsApp Default Message</label>
                            <input type="text" name="whatsapp_message" class="form-control" value="{{ $val('whatsapp_message') }}" placeholder="Hi! I have a question about…">
                            <div class="form-text">The floating WhatsApp button uses the <strong>WhatsApp number</strong> from the Contact section above. Fill that to show the button.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Email / SMTP --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header"><span class="sec-icon"><i class="bi bi-envelope-at"></i></span> Email (SMTP)</div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Used to send the contact-form confirmation (to the visitor) and notification (to you). Leave blank to disable email sending.</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">SMTP Host</label>
                            <input type="text" name="mail_host" class="form-control" value="{{ $val('mail_host') }}" placeholder="smtp.gmail.com">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Port</label>
                            <input type="text" name="mail_port" class="form-control" value="{{ $val('mail_port') }}" placeholder="587">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Encryption</label>
                            <select name="mail_encryption" class="form-select">
                                @php($enc = $val('mail_encryption'))
                                <option value="" {{ $enc === '' ? 'selected' : '' }}>None</option>
                                <option value="tls" {{ $enc === 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ $enc === 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SMTP Username</label>
                            <input type="text" name="mail_username" class="form-control" value="{{ $val('mail_username') }}" placeholder="you@gmail.com" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">SMTP Password</label>
                            <input type="password" name="mail_password" class="form-control" value="{{ $val('mail_password') }}" placeholder="••••••••" autocomplete="new-password">
                            <div class="form-text">For Gmail, use an <strong>App Password</strong> (not your normal password).</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From Address</label>
                            <input type="email" name="mail_from_address" class="form-control" value="{{ $val('mail_from_address') }}" placeholder="no-reply@yoursite.com">
                            <div class="form-text">The "from" address shown on outgoing emails.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From Name</label>
                            <input type="text" name="mail_from_name" class="form-control" value="{{ $val('mail_from_name') }}" placeholder="{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}">
                        </div>
                    </div>
                    <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i> Notifications are sent to the <strong>Email</strong> address in the Contact section above.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-brand">
            <i class="bi bi-save me-1"></i> Save Company Info
        </button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Cancel</a>
    </div>
</form>
@endsection
