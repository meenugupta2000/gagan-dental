<?php

use App\Http\Controllers\AboutSectionController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\HeroSectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaItemController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TreatmentCategoryController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoTestimonialController;
use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------------------------
// Public website (served by Laravel/Blade, content fed from the admin panel)
// ---------------------------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
// Old theme links still point to index.html — keep them working.
Route::get('index.html', fn () => redirect()->route('home'));

// Public JSON feed for the hero section (kept for any client-side use).
Route::get('api/hero', [HeroSectionController::class, 'api'])->name('api.hero');

// Public "Treatments" pages (listing + single treatment), optionally
// filtered by ?category=.
Route::get('treatments', [TreatmentController::class, 'page'])->name('treatments');
Route::get('treatments/{slug}', [TreatmentController::class, 'show'])->name('treatments.show');

// Public "Offers" page.
Route::get('offers', [OfferController::class, 'page'])->name('offers');

// Public "About" page (wired to the About section in the admin panel).
Route::get('about', [AboutSectionController::class, 'page'])->name('about');

// Public "Testimonials" page (YouTube video testimonials).
Route::get('testimonials', [VideoTestimonialController::class, 'page'])->name('testimonials');

// Public "FAQs" page.
Route::get('faqs', [FaqController::class, 'page'])->name('faqs');

// Public "Achievements" page.
Route::get('achievements', [AchievementController::class, 'page'])->name('achievements');

Route::get('media', [MediaItemController::class, 'page'])->name('media');

// Public "Blog" pages (listing + single article).
Route::get('blog', [BlogController::class, 'page'])->name('blog');
Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Public content pages (Privacy Policy, Terms & Conditions, etc.).
Route::get('page/{slug}', [PageController::class, 'show'])->name('page');

// Public "Contact" page + form submission.
Route::get('contact', [ContactController::class, 'show'])->name('contact');
Route::post('contact', [ContactController::class, 'submit'])->name('contact.submit');

// Public "Book an Appointment" page + form submission.
Route::get('appointment', [AppointmentController::class, 'create'])->name('appointment');
Route::post('appointment', [AppointmentController::class, 'store'])->name('appointment.store');

// Public newsletter subscription (footer form).
Route::post('newsletter', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

// Public site-wide widget settings (WhatsApp button + Tawk.to), used on every page.
Route::get('api/site-widgets', [CompanyInfoController::class, 'widgets'])->name('api.widgets');

// Authentication (no public registration — accounts are created by admins).
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin panel.
// Bare /admin has no page of its own — send it to the dashboard (which in turn
// redirects guests to the login page).
Route::get('admin', fn () => redirect()->route('admin.dashboard'));

Route::middleware(['auth', 'active'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::middleware('permission:manage users')->group(function () {
            Route::resource('users', UserController::class)->except('show');
        });

        Route::middleware('permission:manage roles')->group(function () {
            Route::resource('roles', RoleController::class)->except('show');
        });

        Route::middleware('permission:manage company')->group(function () {
            Route::get('company', [CompanyInfoController::class, 'edit'])->name('company.edit');
            Route::put('company', [CompanyInfoController::class, 'update'])->name('company.update');
        });

        Route::middleware('permission:manage templates')->group(function () {
            Route::get('templates', [EmailTemplateController::class, 'index'])->name('templates.index');
            Route::get('templates/{template}/edit', [EmailTemplateController::class, 'edit'])->name('templates.edit');
            Route::put('templates/{template}', [EmailTemplateController::class, 'update'])->name('templates.update');
        });

        Route::middleware('permission:manage pages')->group(function () {
            Route::patch('pages/{page}/toggle', [PageController::class, 'toggle'])->name('pages.toggle');
            Route::resource('pages', PageController::class)->except('show');
        });

        Route::middleware('permission:manage subscribers')->group(function () {
            Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
            Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
        });

        Route::middleware('permission:manage messages')->group(function () {
            Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
            Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
            Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
        });

        Route::middleware('permission:manage appointments')->group(function () {
            Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
            Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
            Route::patch('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
            Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
        });

        Route::middleware('permission:manage hero')->group(function () {
            Route::get('hero', [HeroSectionController::class, 'edit'])->name('hero.edit');
            Route::put('hero', [HeroSectionController::class, 'update'])->name('hero.update');
        });

        Route::middleware('permission:manage about')->group(function () {
            Route::get('about', [AboutSectionController::class, 'edit'])->name('about.edit');
            Route::put('about', [AboutSectionController::class, 'update'])->name('about.update');
        });

        Route::middleware('permission:manage features')->group(function () {
            Route::patch('features/{feature}/toggle', [FeatureController::class, 'toggle'])->name('features.toggle');
            Route::resource('features', FeatureController::class)->except('show');
        });

        Route::middleware('permission:manage testimonials')->group(function () {
            Route::patch('testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggle'])->name('testimonials.toggle');
            Route::resource('testimonials', TestimonialController::class)->except('show');
        });

        Route::middleware('permission:manage video testimonials')->group(function () {
            Route::patch('video-testimonials/{videoTestimonial}/toggle', [VideoTestimonialController::class, 'toggle'])->name('video-testimonials.toggle');
            Route::resource('video-testimonials', VideoTestimonialController::class)
                ->except('show')
                ->parameters(['video-testimonials' => 'videoTestimonial']);
        });

        Route::middleware('permission:manage faqs')->group(function () {
            Route::patch('faqs/{faq}/toggle', [FaqController::class, 'toggle'])->name('faqs.toggle');
            Route::resource('faqs', FaqController::class)->except('show');
        });

        Route::middleware('permission:manage achievements')->group(function () {
            Route::patch('achievements/{achievement}/toggle', [AchievementController::class, 'toggle'])->name('achievements.toggle');
            Route::resource('achievements', AchievementController::class)->except('show');
        });

        Route::middleware('permission:manage team')->group(function () {
            Route::patch('team/{teamMember}/toggle', [TeamMemberController::class, 'toggle'])->name('team.toggle');
            Route::resource('team', TeamMemberController::class)
                ->except('show')
                ->parameters(['team' => 'teamMember']);
        });

        Route::middleware('permission:manage media')->group(function () {
            Route::patch('media/{mediaItem}/toggle', [MediaItemController::class, 'toggle'])->name('media.toggle');
            Route::resource('media', MediaItemController::class)
                ->except('show')
                ->parameters(['media' => 'mediaItem']);
        });

        Route::middleware('permission:manage offers')->group(function () {
            Route::patch('offers/{offer}/toggle', [OfferController::class, 'toggle'])->name('offers.toggle');
            Route::resource('offers', OfferController::class)->except('show');
        });

        Route::middleware('permission:manage blogs')->group(function () {
            Route::patch('blogs/{blog}/toggle', [BlogController::class, 'toggle'])->name('blogs.toggle');
            Route::resource('blogs', BlogController::class)->except('show');
        });

        Route::middleware('permission:manage treatment categories')->group(function () {
            Route::patch('treatment-categories/{treatmentCategory}/toggle', [TreatmentCategoryController::class, 'toggle'])->name('treatment-categories.toggle');
            Route::resource('treatment-categories', TreatmentCategoryController::class)
                ->except('show')
                ->parameters(['treatment-categories' => 'treatmentCategory']);
        });

        Route::middleware('permission:manage treatments')->group(function () {
            Route::patch('treatments/{treatment}/toggle', [TreatmentController::class, 'toggle'])->name('treatments.toggle');
            Route::resource('treatments', TreatmentController::class)->except('show');
        });
    });
