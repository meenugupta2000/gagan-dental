<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Offer;
use App\Models\Testimonial;
use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Starter content for the clinic website so every page renders with real
 * sections from day one. All of it is meant to be edited/replaced from the
 * admin panel — images in particular are left empty for the admin to upload.
 */
class ClinicContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCategoriesAndTreatments();
        $this->seedFeatures();
        $this->seedTestimonials();
        $this->seedOffers();
    }

    protected function seedCategoriesAndTreatments(): void
    {
        $catalog = [
            'General Dentistry' => [
                'description' => 'Everyday dental care for the whole family — check-ups, cleanings, fillings and more.',
                'treatments' => [
                    ['name' => 'Dental Check-up & Cleaning', 'duration' => '30–45 mins', 'actual_price' => 999, 'show_on_home' => true],
                    ['name' => 'Tooth-Coloured Fillings', 'duration' => '30–60 mins', 'actual_price' => 1500],
                    ['name' => 'Root Canal Treatment', 'duration' => '1–2 visits', 'actual_price' => 6000, 'badge' => 'Painless'],
                    ['name' => 'Wisdom Tooth Extraction', 'duration' => '45–60 mins', 'actual_price' => 5000],
                ],
            ],
            'Cosmetic Dentistry' => [
                'description' => 'Smile-enhancing treatments that brighten, straighten and perfect your teeth.',
                'treatments' => [
                    ['name' => 'Teeth Whitening', 'duration' => '60 mins', 'actual_price' => 8000, 'deal_price' => 5999, 'badge' => 'Popular', 'show_on_home' => true],
                    ['name' => 'Porcelain Veneers', 'duration' => '2–3 visits', 'actual_price' => 12000],
                    ['name' => 'Smile Makeover', 'duration' => 'Multiple visits', 'show_on_home' => true],
                ],
            ],
            'Orthodontics' => [
                'description' => 'Braces and clear aligners to straighten teeth for children and adults.',
                'treatments' => [
                    ['name' => 'Metal & Ceramic Braces', 'duration' => '12–24 months', 'actual_price' => 35000],
                    ['name' => 'Clear Aligners', 'duration' => '6–18 months', 'badge' => 'Invisible', 'show_on_home' => true],
                ],
            ],
            'Implants & Prosthetics' => [
                'description' => 'Permanent, natural-looking replacements for missing teeth.',
                'treatments' => [
                    ['name' => 'Dental Implants', 'duration' => '2–3 visits', 'actual_price' => 30000, 'badge' => 'Advanced', 'show_on_home' => true],
                    ['name' => 'Crowns & Bridges', 'duration' => '2 visits', 'actual_price' => 4500],
                    ['name' => 'Complete & Partial Dentures', 'duration' => '3–4 visits'],
                ],
            ],
            'Facial Aesthetics' => [
                'description' => 'Non-surgical aesthetic treatments for naturally youthful, refreshed skin.',
                'treatments' => [
                    ['name' => 'Botox & Dermal Fillers', 'duration' => '30–45 mins'],
                    ['name' => 'Skin Rejuvenation', 'duration' => '45–60 mins'],
                    ['name' => 'Lip Enhancement', 'duration' => '30 mins'],
                ],
            ],
        ];

        $categorySort = 0;
        foreach ($catalog as $categoryName => $data) {
            $category = TreatmentCategory::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                [
                    'name' => $categoryName,
                    'description' => $data['description'],
                    'sort_order' => $categorySort++,
                    'is_active' => true,
                ]
            );

            $treatmentSort = 0;
            foreach ($data['treatments'] as $t) {
                Treatment::firstOrCreate(
                    ['slug' => Str::slug($t['name'])],
                    [
                        'name' => $t['name'],
                        'duration' => $t['duration'] ?? null,
                        'treatment_category_id' => $category->id,
                        'badge' => $t['badge'] ?? null,
                        'actual_price' => $t['actual_price'] ?? null,
                        'deal_price' => $t['deal_price'] ?? null,
                        'description' => '<p>Ask our team for full details about this treatment — indications, procedure steps, aftercare and pricing are personalised to every patient after a consultation.</p>',
                        'sort_order' => $treatmentSort++,
                        'is_active' => true,
                        'show_on_home' => $t['show_on_home'] ?? false,
                    ]
                );
            }
        }
    }

    protected function seedFeatures(): void
    {
        $features = [
            ['title' => 'Experienced Specialists', 'description' => 'Qualified dental and aesthetic experts with years of hands-on experience.'],
            ['title' => 'Advanced Equipment', 'description' => 'Modern technology and strict sterilisation protocols for safe, precise treatment.'],
            ['title' => 'Painless & Gentle Care', 'description' => 'Comfort-first dentistry — from anxious first-timers to complex procedures.'],
            ['title' => 'Transparent Pricing', 'description' => 'Clear treatment plans and honest pricing with no hidden costs.'],
        ];

        foreach ($features as $i => $f) {
            Feature::firstOrCreate(
                ['title' => $f['title']],
                ['description' => $f['description'], 'sort_order' => $i, 'is_active' => true]
            );
        }
    }

    protected function seedTestimonials(): void
    {
        $testimonials = [
            [
                'name' => 'Ritika S.',
                'role' => 'Patient',
                'title' => 'Completely painless root canal',
                'quote' => 'I was terrified of getting a root canal but the whole procedure was completely painless. The team explained every step and kept me comfortable throughout.',
                'rating' => 5,
            ],
            [
                'name' => 'Amandeep K.',
                'role' => 'Patient',
                'title' => 'My smile looks amazing',
                'quote' => 'Got my teeth whitening and veneers done here. The results are natural and my smile looks amazing — totally worth it!',
                'rating' => 5,
            ],
            [
                'name' => 'Rohit M.',
                'role' => 'Patient',
                'title' => 'Great with kids',
                'quote' => 'Brought my 7-year-old for his first dental visit. The doctors were so patient and friendly that he actually looks forward to check-ups now.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $i => $t) {
            Testimonial::firstOrCreate(
                ['name' => $t['name']],
                [
                    'role' => $t['role'],
                    'title' => $t['title'],
                    'quote' => $t['quote'],
                    'rating' => $t['rating'],
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedOffers(): void
    {
        $offers = [
            [
                'title' => 'Free First Consultation',
                'description' => 'New to the clinic? Your first dental consultation is on us — includes a complete oral examination and treatment plan.',
            ],
            [
                'title' => 'Teeth Whitening Special',
                'description' => 'Professional in-clinic whitening at a special price this month. Brighten your smile in a single visit.',
            ],
        ];

        foreach ($offers as $i => $o) {
            Offer::firstOrCreate(
                ['title' => $o['title']],
                ['description' => $o['description'], 'sort_order' => $i, 'is_active' => true]
            );
        }
    }
}
