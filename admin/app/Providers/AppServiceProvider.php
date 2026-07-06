<?php

namespace App\Providers;

use App\Models\CompanyInfo;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Apply any pending migrations automatically after the migration files
        // change (e.g. after uploading new code). Cheap no-op when unchanged.
        $this->autoMigrate();

        // Build asset/route/storage URLs from the host actually used to reach the
        // site (localhost, a LAN IP for phone testing, or a real domain later) —
        // keeping APP_URL's path — so images never get stuck pointing at "localhost".
        if (! $this->app->runningInConsole() && request()) {
            $path = parse_url((string) config('app.url'), PHP_URL_PATH) ?? '';
            // Only keep APP_URL's path when the request actually lives under it
            // (Apache serves the site at /GaganDentalAndClininc). Under
            // `php artisan serve` the app is at the server root, so drop it.
            if ($path && ! str_starts_with(request()->getRequestUri(), $path)) {
                $path = '';
            }
            $root = request()->getSchemeAndHttpHost() . $path;
            URL::forceRootUrl($root);
            config(['filesystems.disks.public.url' => $root . '/storage']);
        }

        // Render pagination with Bootstrap 5 markup (admin UI is Bootstrap, not Tailwind).
        Paginator::useBootstrapFive();

        // Super Admin bypasses all permission/role checks.
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        // Make company info available to every view (logo, name, etc.).
        View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Schema::hasTable('company_info')) {
                $view->with('company', CompanyInfo::current());
            }

            // Inner-page top banner (managed in the Hero Section module).
            if (\Illuminate\Support\Facades\Schema::hasTable('hero_sections')) {
                $view->with('pageBanner', \App\Models\HeroSection::current()->inner_banner_or_default);
            }
        });

        // "Treatments" mega-menu: active categories, each with its active
        // treatments, for the public site header.
        View::composer('partials.header', function ($view) {
            $menuCategories = collect();

            if (\Illuminate\Support\Facades\Schema::hasTable('treatments')) {
                $menuCategories = \App\Models\TreatmentCategory::where('is_active', true)
                    ->orderBy('sort_order')->orderBy('name')
                    ->with(['treatments' => fn ($q) => $q->where('is_active', true)
                        ->orderBy('sort_order')->orderBy('name')])
                    ->get()
                    ->map(fn ($category) => (object) [
                        'category' => $category,
                        'treatments' => $category->treatments,
                    ])
                    ->filter(fn ($m) => $m->treatments->isNotEmpty())
                    ->values();
            }

            $view->with('menuCategories', $menuCategories);
        });
    }

    /**
     * Run pending migrations automatically when the migrations folder changes.
     *
     * Designed to be a near-zero-cost no-op on normal requests: it only does
     * real work when the set/mtime of files in database/migrations changes
     * (i.e. right after new code is uploaded). A cache lock prevents two
     * concurrent requests from migrating at the same time, and any failure is
     * swallowed so the site never breaks because of this convenience.
     */
    protected function autoMigrate(): void
    {
        // Never during artisan/queue/console, and only when explicitly enabled.
        if ($this->app->runningInConsole() || ! config('app.auto_migrate')) {
            return;
        }

        try {
            $dir = database_path('migrations');
            if (! is_dir($dir)) {
                return;
            }

            // Signature of the migrations folder (filenames + last-modified).
            $files = glob($dir . '/*.php') ?: [];
            sort($files);
            $signature = md5(implode('|', array_map(
                fn ($f) => basename($f) . ':' . filemtime($f),
                $files
            )));

            // Unchanged since the last successful check → nothing to do.
            if (Cache::get('auto_migrate_signature') === $signature) {
                return;
            }

            // Serialize across concurrent requests; if another holds it, skip.
            $lock = Cache::lock('auto_migrate_lock', 120);
            if (! $lock->get()) {
                return;
            }

            try {
                $migrator = $this->app->make('migrator');
                $repository = $migrator->getRepository();

                if (! $repository->repositoryExists()) {
                    // Fresh database — run everything (also creates the table).
                    Artisan::call('migrate', ['--force' => true]);
                } else {
                    $ran = $repository->getRan();
                    $pending = array_diff(
                        array_map(fn ($f) => basename($f, '.php'), $files),
                        $ran
                    );

                    if (count($pending) > 0) {
                        Artisan::call('migrate', ['--force' => true]);
                    }
                }

                // Remember this folder state so subsequent requests are no-ops.
                Cache::put('auto_migrate_signature', $signature, now()->addDays(30));
            } finally {
                $lock->release();
            }
        } catch (\Throwable $e) {
            // Auto-migrate is a convenience — never let it take the site down.
            report($e);
        }
    }
}
