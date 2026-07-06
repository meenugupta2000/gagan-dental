<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\Blog;
use App\Models\Feature;
use App\Models\HeroSection;
use App\Models\Offer;
use App\Models\Testimonial;
use App\Models\Treatment;
use App\Models\TreatmentCategory;

class HomeController extends Controller
{
    /**
     * The public website home page (served by Laravel, data from the admin).
     */
    public function index()
    {
        $hero = HeroSection::current();
        $about = AboutSection::current();
        $features = Feature::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
        $blogs = Blog::where('is_active', true)->orderBy('sort_order')->orderByDesc('id')->take(3)->get();

        // Treatment categories strip → active categories with their active treatment counts.
        $categories = TreatmentCategory::where('is_active', true)
            ->withCount(['treatments as treatments_count' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        // "Our Treatments" → active treatments flagged Show on Home Page.
        $treatments = Treatment::where('is_active', true)
            ->where('show_on_home', true)
            ->with(['category', 'images'])
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        // "Special Offers" → all active offers.
        $offers = Offer::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('home', compact('hero', 'about', 'features', 'testimonials', 'blogs', 'categories', 'treatments', 'offers'));
    }
}
