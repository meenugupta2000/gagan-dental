<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &middot; {{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }} Admin</title>

    {{-- Favicon (same as the public website — from Company Info when set) --}}
    @if (($company ?? null) && $company->favicon_path)
        <link rel="shortcut icon" type="image/x-icon" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($company->favicon_path) }}">
    @endif

    {{-- Apply saved theme before paint to avoid a flash of the wrong theme --}}
    <script>
        (function () {
            try {
                var t = localStorage.getItem('ltc-theme');
                if (!t) { t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'; }
                document.documentElement.setAttribute('data-bs-theme', t);
            } catch (e) { document.documentElement.setAttribute('data-bs-theme', 'light'); }
            // Apply collapsed-sidebar state before paint to avoid a flash.
            try {
                if (localStorage.getItem('ltc-sidebar-collapsed') === '1') {
                    document.documentElement.classList.add('sidebar-collapsed');
                }
            } catch (e) {}
        })();
    </script>

    {{-- Modern typeface --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/trix@2.1.15/dist/trix.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @stack('styles')
</head>
<body>
    @auth
    <div class="ltc-backdrop" id="ltcBackdrop"></div>

    <aside class="ltc-sidebar" id="ltcSidebar">
        <div class="ltc-brand-wrap">
            <a href="{{ route('admin.dashboard') }}" class="brand">
                @if (($company ?? null) && $company->logo_path)
                    <img class="brand-logo-img" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($company->logo_path) }}" alt="{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}">
                @else
                    <span class="brand-mark"><i class="bi bi-heart-pulse-fill"></i></span>
                    Gagan<span>Dental</span>
                @endif
            </a>
            <div class="brand-sub">Admin Panel</div>
        </div>

        <nav class="nav flex-column ltc-nav">
            @can('view dashboard')
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            @endcan

            @can('manage appointments')
            <a href="{{ route('admin.appointments.index') }}" class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}" title="Appointments">
                <i class="bi bi-calendar-check"></i> Appointments
            </a>
            @endcan

            @canany(['manage treatments', 'manage treatment categories', 'manage offers'])
            <div class="nav-section" data-section="clinic">
                <button type="button" class="nav-heading" aria-expanded="true">
                    <span>Clinic</span><i class="bi bi-chevron-down nav-caret"></i>
                </button>
                <div class="nav-group">
                    @can('manage treatments')
                        <a href="{{ route('admin.treatments.index') }}" class="nav-link {{ request()->routeIs('admin.treatments.*') ? 'active' : '' }}" title="Treatments">
                            <i class="bi bi-heart-pulse"></i> Treatments
                        </a>
                    @endcan
                    @can('manage treatment categories')
                        <a href="{{ route('admin.treatment-categories.index') }}" class="nav-link {{ request()->routeIs('admin.treatment-categories.*') ? 'active' : '' }}" title="Treatment Categories">
                            <i class="bi bi-collection"></i> Treatment Categories
                        </a>
                    @endcan
                    @can('manage offers')
                        <a href="{{ route('admin.offers.index') }}" class="nav-link {{ request()->routeIs('admin.offers.*') ? 'active' : '' }}" title="Offers">
                            <i class="bi bi-tag"></i> Offers
                        </a>
                    @endcan
                </div>
            </div>
            @endcanany

            @canany(['manage testimonials', 'manage video testimonials', 'manage faqs', 'manage achievements', 'manage features', 'manage blogs', 'manage pages', 'manage hero', 'manage about'])
            <div class="nav-section" data-section="content">
                <button type="button" class="nav-heading" aria-expanded="true">
                    <span>Content</span><i class="bi bi-chevron-down nav-caret"></i>
                </button>
                <div class="nav-group">
                    @can('manage testimonials')
                        <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" title="Testimonials">
                            <i class="bi bi-chat-quote"></i> Testimonials
                        </a>
                    @endcan
                    @can('manage video testimonials')
                        <a href="{{ route('admin.video-testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.video-testimonials.*') ? 'active' : '' }}" title="Video Testimonials">
                            <i class="bi bi-camera-video"></i> Video Testimonials
                        </a>
                    @endcan
                    @can('manage faqs')
                        <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" title="FAQs">
                            <i class="bi bi-patch-question"></i> FAQs
                        </a>
                    @endcan
                    @can('manage achievements')
                        <a href="{{ route('admin.achievements.index') }}" class="nav-link {{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}" title="Achievements">
                            <i class="bi bi-trophy"></i> Achievements
                        </a>
                    @endcan
                    @can('manage features')
                        <a href="{{ route('admin.features.index') }}" class="nav-link {{ request()->routeIs('admin.features.*') ? 'active' : '' }}" title="Features">
                            <i class="bi bi-stars"></i> Features
                        </a>
                    @endcan
                    @can('manage blogs')
                        <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}" title="Blogs">
                            <i class="bi bi-journal-text"></i> Blogs
                        </a>
                    @endcan
                    @can('manage pages')
                        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" title="Pages">
                            <i class="bi bi-file-earmark-text"></i> Pages
                        </a>
                    @endcan
                    @can('manage hero')
                        <a href="{{ route('admin.hero.edit') }}" class="nav-link {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}" title="Hero Section">
                            <i class="bi bi-easel"></i> Hero Section
                        </a>
                    @endcan
                    @can('manage about')
                        <a href="{{ route('admin.about.edit') }}" class="nav-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}" title="About Section">
                            <i class="bi bi-card-heading"></i> About Section
                        </a>
                    @endcan
                </div>
            </div>
            @endcanany

            @canany(['manage messages', 'manage subscribers', 'manage templates'])
            <div class="nav-section" data-section="inbox">
                <button type="button" class="nav-heading" aria-expanded="true">
                    <span>Inbox &amp; Email</span><i class="bi bi-chevron-down nav-caret"></i>
                </button>
                <div class="nav-group">
                    @can('manage messages')
                    <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" title="Contact Messages">
                        <i class="bi bi-chat-left-text"></i> Messages
                    </a>
                    @endcan
                    @can('manage subscribers')
                    <a href="{{ route('admin.subscribers.index') }}" class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}" title="Subscribers">
                        <i class="bi bi-envelope-heart"></i> Subscribers
                    </a>
                    @endcan
                    @can('manage templates')
                    <a href="{{ route('admin.templates.index') }}" class="nav-link {{ request()->routeIs('admin.templates.*') ? 'active' : '' }}" title="Email Templates">
                        <i class="bi bi-envelope-paper"></i> Email Templates
                    </a>
                    @endcan
                </div>
            </div>
            @endcanany

            @canany(['manage users', 'manage roles', 'manage company'])
            <div class="nav-section" data-section="access">
                <button type="button" class="nav-heading" aria-expanded="true">
                    <span>Administration</span><i class="bi bi-chevron-down nav-caret"></i>
                </button>
                <div class="nav-group">
                    @can('manage users')
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Users">
                            <i class="bi bi-people"></i> Users
                        </a>
                    @endcan
                    @can('manage roles')
                        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" title="Roles &amp; Permissions">
                            <i class="bi bi-shield-lock"></i> Roles &amp; Permissions
                        </a>
                    @endcan
                    @can('manage company')
                        <a href="{{ route('admin.company.edit') }}" class="nav-link {{ request()->routeIs('admin.company.*') ? 'active' : '' }}" title="Company Info">
                            <i class="bi bi-building"></i> Company Info
                        </a>
                    @endcan
                </div>
            </div>
            @endcanany
        </nav>
    </aside>

    <div class="ltc-content">
        <header class="ltc-topbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="ltc-icon-btn d-lg-none" id="ltcSidebarToggle" aria-label="Open menu"><i class="bi bi-list"></i></button>
                <button class="ltc-icon-btn d-none d-lg-inline-flex" id="ltcSidebarCollapse" title="Collapse / expand sidebar" aria-label="Collapse sidebar"><i class="bi bi-list"></i></button>
                <div>
                    <div class="breadcrumb-faint d-none d-md-block">{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}</div>
                    <h1 class="mb-0">@yield('title', 'Dashboard')</h1>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="ltc-icon-btn ltc-theme-toggle" title="Toggle light / dark theme" aria-label="Toggle theme">
                    <i class="bi bi-moon-stars"></i>
                </button>
                <div class="dropdown">
                <a href="#" class="ltc-user-btn d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="ltc-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="d-none d-sm-block text-start">
                        <span class="fw-semibold d-block lh-sm">{{ auth()->user()->name }}</span>
                        <small class="text-muted">{{ auth()->user()->getRoleNames()->first() ?? 'No role' }}</small>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text small text-muted px-2">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                        </form>
                    </li>
                </ul>
                </div>
            </div>
        </header>

        <main class="ltc-main">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Please check the following:</strong></div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Shared slide-in drawer used by every module's Add / Edit forms --}}
    <div class="offcanvas offcanvas-end app-drawer" tabindex="-1" id="appDrawer" aria-labelledby="appDrawerTitle">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="appDrawerTitle" data-drawer-title>Form</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" data-drawer-body></div>
    </div>
    @endauth

    @guest
        @yield('content')
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var sidebar = document.getElementById('ltcSidebar');
            var backdrop = document.getElementById('ltcBackdrop');
            function toggle() {
                sidebar?.classList.toggle('show');
                backdrop?.classList.toggle('show');
            }
            document.getElementById('ltcSidebarToggle')?.addEventListener('click', toggle);
            backdrop?.addEventListener('click', toggle);

            // Collapse the whole sidebar to an icon rail (desktop), persisted.
            var collapseBtn = document.getElementById('ltcSidebarCollapse');
            collapseBtn?.addEventListener('click', function () {
                var collapsed = document.documentElement.classList.toggle('sidebar-collapsed');
                try { localStorage.setItem('ltc-sidebar-collapsed', collapsed ? '1' : '0'); } catch (e) {}
            });

            // Collapsible nav sections (Clinic / Content / Inbox & Email / Administration), persisted.
            var sectionState = {};
            try { sectionState = JSON.parse(localStorage.getItem('ltc-nav-sections')) || {}; } catch (e) {}
            document.querySelectorAll('.nav-section').forEach(function (sec) {
                var key = sec.getAttribute('data-section');
                var heading = sec.querySelector('.nav-heading');
                var hasActive = !!sec.querySelector('.nav-link.active');
                // Restore collapsed state, but always keep the active page's section open.
                if (sectionState[key] === true && !hasActive) {
                    sec.classList.add('collapsed');
                    heading?.setAttribute('aria-expanded', 'false');
                }
                heading?.addEventListener('click', function () {
                    var collapsed = sec.classList.toggle('collapsed');
                    heading.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
                    sectionState[key] = collapsed;
                    try { localStorage.setItem('ltc-nav-sections', JSON.stringify(sectionState)); } catch (e) {}
                });
            });
            // Enable group transitions only after initial state is applied (no load-flash).
            var navEl = document.querySelector('.ltc-nav');
            if (navEl) { requestAnimationFrame(function () { navEl.classList.add('js-nav-ready'); }); }

            // Theme toggle (light / dark) with persistence.
            var toggles = document.querySelectorAll('.ltc-theme-toggle');
            function syncIcons() {
                var dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                toggles.forEach(function (b) {
                    var i = b.querySelector('i');
                    if (i) i.className = dark ? 'bi bi-sun' : 'bi bi-moon-stars';
                    b.setAttribute('title', dark ? 'Switch to light mode' : 'Switch to dark mode');
                });
            }
            syncIcons();
            toggles.forEach(function (b) {
                b.addEventListener('click', function () {
                    var dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                    var next = dark ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-bs-theme', next);
                    try { localStorage.setItem('ltc-theme', next); } catch (e) {}
                    syncIcons();
                });
            });
        })();
    </script>

    {{-- Rich-text editor (loaded globally so it also works inside the AJAX-loaded drawer) --}}
    <script src="https://unpkg.com/trix@2.1.15/dist/trix.umd.min.js"></script>
    <script>
        // Trix ships without underline — register it as a text attribute (<u>) before any editor initializes.
        if (window.Trix && !Trix.config.textAttributes.underline) {
            Trix.config.textAttributes.underline = {
                tagName: 'u',
                inheritable: true,
                parser: function (element) {
                    var style = window.getComputedStyle(element);
                    return style.textDecorationLine === 'underline' || style.textDecoration.indexOf('underline') !== -1;
                }
            };
        }
        // Add an Underline button (with Ctrl/Cmd+U) to every Trix toolbar, including drawer-loaded ones.
        document.addEventListener('trix-initialize', function (e) {
            var toolbar = e.target.toolbarElement;
            if (!toolbar || toolbar.querySelector('[data-trix-attribute="underline"]')) return;
            var italic = toolbar.querySelector('[data-trix-attribute="italic"]');
            if (!italic) return;
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'trix-button trix-button--underline';
            btn.setAttribute('data-trix-attribute', 'underline');
            btn.setAttribute('data-trix-key', 'u');
            btn.setAttribute('title', 'Underline');
            btn.setAttribute('tabindex', '-1');
            btn.textContent = 'U';
            italic.insertAdjacentElement('afterend', btn);
        });

        // No file uploads in Trix (no upload endpoint configured).
        document.addEventListener('trix-file-accept', function (e) { e.preventDefault(); });

        // Live image preview for any file input with data-preview-target="#img" (works in drawers too).
        document.addEventListener('change', function (e) {
            if (!e.target || !e.target.matches('input[type="file"][data-preview-target]')) return;
            var file = e.target.files && e.target.files[0];
            var img = document.querySelector(e.target.getAttribute('data-preview-target'));
            if (!file || !img) return;
            img.src = URL.createObjectURL(file);
            img.style.display = 'block';
            var ph = img.parentElement && img.parentElement.querySelector('[data-preview-placeholder]');
            if (ph) ph.style.display = 'none';
        });

        // Reusable image drag-and-drop zone ([data-dropzone]) — delegated so it
        // works on full pages and inside AJAX-loaded drawers alike.
        function dzShow(zone, file) {
            if (!file || !/^image\//.test(file.type)) return;
            var img = zone.querySelector('[data-dropzone-preview]');
            var prompt = zone.querySelector('[data-dropzone-prompt]');
            if (img) { img.src = URL.createObjectURL(file); img.style.display = 'block'; }
            if (prompt) prompt.style.display = 'none';
            zone.classList.add('has-image');
        }
        document.addEventListener('click', function (e) {
            var zone = e.target.closest && e.target.closest('[data-dropzone]');
            if (!zone) return;
            var inp = zone.querySelector('[data-dropzone-input]');
            if (inp) inp.click();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Enter' && e.key !== ' ') return;
            var zone = e.target.closest && e.target.closest('[data-dropzone]');
            if (!zone) return;
            e.preventDefault();
            var inp = zone.querySelector('[data-dropzone-input]');
            if (inp) inp.click();
        });
        ['dragenter', 'dragover'].forEach(function (ev) {
            document.addEventListener(ev, function (e) {
                var zone = e.target.closest && e.target.closest('[data-dropzone]');
                if (!zone) return;
                e.preventDefault();
                zone.classList.add('is-dragover');
            });
        });
        ['dragleave', 'dragend'].forEach(function (ev) {
            document.addEventListener(ev, function (e) {
                var zone = e.target.closest && e.target.closest('[data-dropzone]');
                if (zone) zone.classList.remove('is-dragover');
            });
        });
        document.addEventListener('drop', function (e) {
            var zone = e.target.closest && e.target.closest('[data-dropzone]');
            if (!zone) return;
            e.preventDefault();
            zone.classList.remove('is-dragover');
            var inp = zone.querySelector('[data-dropzone-input]');
            var files = e.dataTransfer && e.dataTransfer.files;
            if (!inp || !files || !files.length) return;
            try { var dt = new DataTransfer(); dt.items.add(files[0]); inp.files = dt.files; }
            catch (err) { inp.files = files; }
            dzShow(zone, files[0]);
        });
        document.addEventListener('change', function (e) {
            if (!e.target || !e.target.matches('[data-dropzone-input]')) return;
            var zone = e.target.closest('[data-dropzone]');
            if (zone && e.target.files && e.target.files[0]) dzShow(zone, e.target.files[0]);
        });

        // Multi-image drag-and-drop ([data-multi-dropzone]) — accumulates several
        // files across multiple drops/picks; delegated so it works inside drawers.
        function mzInput(zone) { return zone.querySelector('[data-multi-input]'); }
        function mzPreviewBox(zone) {
            var col = zone.closest('.col-12') || zone.parentElement;
            return col ? col.querySelector('[data-multi-preview]') : null;
        }
        function mzRebuild(input) {
            var files = input._mzFiles || [];
            try {
                var dt = new DataTransfer();
                files.forEach(function (f) { dt.items.add(f); });
                input.files = dt.files;
            } catch (err) { /* older browsers: leave as-is */ }
        }
        function mzRender(zone) {
            var input = mzInput(zone);
            var box = mzPreviewBox(zone);
            if (!input || !box) return;
            box.innerHTML = '';
            (input._mzFiles || []).forEach(function (file, i) {
                var thumb = document.createElement('div');
                thumb.className = 'ltc-gallery-thumb';
                var img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                var x = document.createElement('button');
                x.type = 'button'; x.className = 'ltc-gallery-x'; x.innerHTML = '&times;';
                x.setAttribute('data-remove-pending', i);
                thumb.appendChild(img); thumb.appendChild(x);
                box.appendChild(thumb);
            });
        }
        function mzAdd(zone, fileList) {
            var input = mzInput(zone);
            if (!input) return;
            input._mzFiles = input._mzFiles || [];
            Array.prototype.forEach.call(fileList, function (f) {
                if (/^image\//.test(f.type)) input._mzFiles.push(f);
            });
            mzRebuild(input);
            mzRender(zone);
        }
        document.addEventListener('click', function (e) {
            var zone = e.target.closest && e.target.closest('[data-multi-dropzone]');
            // remove a pending (not-yet-uploaded) file
            var rmPending = e.target.closest && e.target.closest('[data-remove-pending]');
            if (rmPending && zone) {
                e.preventDefault(); e.stopPropagation();
                var idx = parseInt(rmPending.getAttribute('data-remove-pending'), 10);
                var input = mzInput(zone);
                if (input && input._mzFiles) { input._mzFiles.splice(idx, 1); mzRebuild(input); mzRender(zone); }
                return;
            }
            // remove an existing (already-saved) image
            var rmExisting = e.target.closest && e.target.closest('[data-remove-existing]');
            if (rmExisting) {
                e.preventDefault(); e.stopPropagation();
                var card = rmExisting.closest('[data-existing-thumb]');
                if (!card) return;
                var id = card.getAttribute('data-id');
                var form = card.closest('form');
                var holder = form ? form.querySelector('[data-remove-images-container]') : null;
                if (holder && id) {
                    var h = document.createElement('input');
                    h.type = 'hidden'; h.name = 'remove_images[]'; h.value = id;
                    holder.appendChild(h);
                }
                card.remove();
                return;
            }
            if (zone) { var inp = mzInput(zone); if (inp) inp.click(); }
        });
        document.addEventListener('drop', function (e) {
            var zone = e.target.closest && e.target.closest('[data-multi-dropzone]');
            if (!zone) return;
            e.preventDefault();
            zone.classList.remove('is-dragover');
            var files = e.dataTransfer && e.dataTransfer.files;
            if (files && files.length) mzAdd(zone, files);
        });
        ['dragenter', 'dragover'].forEach(function (ev) {
            document.addEventListener(ev, function (e) {
                var zone = e.target.closest && e.target.closest('[data-multi-dropzone]');
                if (zone) { e.preventDefault(); zone.classList.add('is-dragover'); }
            });
        });
        document.addEventListener('change', function (e) {
            if (!e.target || !e.target.matches('[data-multi-input]')) return;
            var zone = e.target.closest('[data-multi-dropzone]');
            if (!zone || e.target._mzBuilding) return;
            var picked = e.target.files;
            if (!picked || !picked.length) return;
            // Capture the just-picked files, then rebuild the input from the accumulator.
            e.target._mzFiles = e.target._mzFiles || [];
            Array.prototype.forEach.call(picked, function (f) {
                if (/^image\//.test(f.type)) e.target._mzFiles.push(f);
            });
            e.target._mzBuilding = true;     // guard: mzRebuild reassigns .files (no change event, but be safe)
            mzRebuild(e.target);
            e.target._mzBuilding = false;
            mzRender(zone);
        });
    </script>

    {{-- Animated drawer controller: opens Add/Edit forms in a slide-in panel and submits them via AJAX --}}
    <script>
        (function () {
            var drawerEl = document.getElementById('appDrawer');
            if (!drawerEl || !window.bootstrap) return;

            var offcanvas = bootstrap.Offcanvas.getOrCreateInstance(drawerEl);
            var titleEl = drawerEl.querySelector('[data-drawer-title]');
            var bodyEl = drawerEl.querySelector('[data-drawer-body]');
            var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            function setLoading() {
                bodyEl.innerHTML = '<div class="drawer-loading"><div class="spinner-border text-secondary" role="status"></div></div>';
            }

            function escapeHtml(s) {
                var d = document.createElement('div');
                d.textContent = s == null ? '' : s;
                return d.innerHTML;
            }

            // Open the drawer and load the form for any element marked with data-drawer.
            document.addEventListener('click', function (e) {
                var trigger = e.target.closest('[data-drawer]');
                if (trigger) {
                    e.preventDefault();
                    var url = trigger.getAttribute('href') || trigger.getAttribute('data-drawer-url');
                    titleEl.textContent = trigger.getAttribute('data-drawer-title') || 'Form';
                    setLoading();
                    offcanvas.show();
                    fetch(url, { headers: { 'X-Drawer': '1', 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function (r) { return r.text(); })
                        .then(function (html) { bodyEl.innerHTML = html; })
                        .catch(function () {
                            bodyEl.innerHTML = '<div class="alert alert-danger">Could not load the form. Please try again.</div>';
                        });
                    return;
                }
                // Cancel button inside the drawer just closes it.
                var cancel = e.target.closest('[data-drawer-cancel]');
                if (cancel && drawerEl.contains(cancel)) {
                    e.preventDefault();
                    offcanvas.hide();
                }
            });

            // Submit drawer forms via AJAX so the panel stays open on validation errors.
            document.addEventListener('submit', function (e) {
                var form = e.target;
                if (!form.matches('form[data-drawer-form]') || !drawerEl.contains(form)) return;
                e.preventDefault();
                clearErrors(form);

                var btn = form.querySelector('[type="submit"]');
                var oldHtml = btn ? btn.innerHTML : '';
                if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving…'; }

                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: new FormData(form),
                }).then(function (r) {
                    return r.json().then(function (data) { return { status: r.status, data: data }; })
                        .catch(function () { return { status: r.status, data: {} }; });
                }).then(function (res) {
                    if (res.status >= 200 && res.status < 300 && res.data.redirect) {
                        window.location.href = res.data.redirect;
                        return;
                    }
                    renderErrors(form, res.status === 422 ? (res.data.errors || {}) : {}, res.data.message);
                    if (btn) { btn.disabled = false; btn.innerHTML = oldHtml; }
                }).catch(function () {
                    renderErrors(form, {}, 'Network error. Please try again.');
                    if (btn) { btn.disabled = false; btn.innerHTML = oldHtml; }
                });
            });

            function clearErrors(form) {
                form.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
                form.querySelectorAll('.drawer-error-summary').forEach(function (el) { el.remove(); });
            }

            function renderErrors(form, errors, message) {
                var msgs = [];
                Object.keys(errors).forEach(function (key) {
                    (errors[key] || []).forEach(function (m) { msgs.push(m); });
                    var base = key.split('.')[0];
                    var field = form.querySelector('[name="' + base + '"], [name="' + base + '[]"]');
                    if (field) field.classList.add('is-invalid');
                });
                var summary = document.createElement('div');
                summary.className = 'alert alert-danger drawer-error-summary';
                var inner = msgs.length
                    ? '<ul class="mb-0">' + msgs.map(function (m) { return '<li>' + escapeHtml(m) + '</li>'; }).join('') + '</ul>'
                    : escapeHtml(message || 'Please check the form and try again.');
                summary.innerHTML = '<div class="d-flex align-items-center mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Please check the following:</strong></div>' + inner;
                form.prepend(summary);
                bodyEl.scrollTop = 0;
            }

            // Free up the DOM (and any Trix instance) when the drawer closes.
            drawerEl.addEventListener('hidden.bs.offcanvas', function () { bodyEl.innerHTML = ''; });
        })();
    </script>
    @stack('scripts')
</body>
</html>
