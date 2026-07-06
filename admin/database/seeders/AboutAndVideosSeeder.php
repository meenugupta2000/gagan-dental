<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\AboutSection;
use App\Models\Faq;
use App\Models\VideoTestimonial;
use Illuminate\Database\Seeder;

/**
 * Rich starter content for the public About page (Dr. Gaganpreet Kaur) and a
 * few sample video testimonials. All of it is meant to be edited/replaced from
 * the admin panel. The About content is only filled when it is still empty, so
 * re-running this seeder never overwrites the admin's own edits.
 */
class AboutAndVideosSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAbout();
        $this->seedVideoTestimonials();
        $this->seedFaqs();
        $this->seedAchievements();
    }

    protected function seedAchievements(): void
    {
        $items = [
            ['title' => 'Best Cosmetic Dentist Award', 'notes' => 'Recognised for excellence in smile design and cosmetic dentistry.'],
            ['title' => 'Certificate in Advanced Cosmetology — FMC', 'notes' => 'Advanced training in facial aesthetics and cosmetology.'],
            ['title' => 'Fellowship in Aesthetic Medicine (FAM, USA)', 'notes' => 'International fellowship in aesthetic medicine.'],
            ['title' => 'Excellence in Patient Care', 'notes' => 'Honoured for outstanding, patient-first clinical care.'],
            ['title' => 'Guest Speaker — Dental Conference', 'notes' => 'Invited speaker on modern smile-design techniques.'],
            ['title' => 'Community Dental Health Camp', 'notes' => 'Led a free dental check-up camp for the local community.'],
        ];

        foreach ($items as $i => $a) {
            Achievement::firstOrCreate(
                ['title' => $a['title']],
                ['notes' => $a['notes'], 'sort_order' => $i, 'is_active' => true]
            );
        }
    }

    protected function seedFaqs(): void
    {
        $faqs = [
            [
                'question' => 'How often should I visit the dentist?',
                'answer' => 'For most people we recommend a routine check-up and professional cleaning every six months. Regular visits help us catch small issues early — before they become painful or expensive to treat.',
            ],
            [
                'question' => 'Is teeth whitening safe for my teeth?',
                'answer' => 'Yes. Professional, dentist-supervised whitening is safe and effective. We assess your teeth and gums first, protect the soft tissues, and use clinically proven products to brighten your smile without damaging the enamel.',
            ],
            [
                'question' => 'Do dental implants or extractions hurt?',
                'answer' => 'Comfort is our priority. Procedures are carried out under effective local anaesthesia, so you should feel little to no pain during treatment. We also guide you through simple aftercare to keep you comfortable as you heal.',
            ],
            [
                'question' => 'Is a root canal really painful?',
                'answer' => 'This is one of the biggest myths in dentistry. A modern root canal is virtually painless — in fact it relieves the pain caused by an infected tooth. Most patients say it feels no different from having a routine filling.',
            ],
            [
                'question' => 'How long do braces or clear aligners take?',
                'answer' => 'It depends on your case, but treatment typically ranges from 6 to 24 months. After an assessment we will give you a personalised timeline and show you what to expect at each stage.',
            ],
            [
                'question' => 'At what age should my child first see a dentist?',
                'answer' => 'We recommend a first visit by your child\'s first birthday, or when their first tooth appears. Early, friendly visits help children feel relaxed at the dentist and set them up for a lifetime of healthy smiles.',
            ],
            [
                'question' => 'Do you offer emergency dental care?',
                'answer' => 'Yes. If you have severe pain, swelling, a broken tooth or a knocked-out tooth, please call us right away — we will do our best to see you as soon as possible and relieve your discomfort.',
            ],
            [
                'question' => 'How do I book an appointment?',
                'answer' => 'You can book online through the "Book an Appointment" button anywhere on this website, or simply call or WhatsApp us. Our team will confirm a convenient date and time and answer any questions you have.',
            ],
        ];

        foreach ($faqs as $i => $f) {
            Faq::firstOrCreate(
                ['question' => $f['question']],
                ['answer' => $f['answer'], 'sort_order' => $i, 'is_active' => true]
            );
        }
    }

    protected function seedAbout(): void
    {
        $about = AboutSection::current();

        // Don't clobber content the admin may have already written.
        if (filled($about->body)) {
            return;
        }

        $about->update([
            'subtitle' => 'Get To Know Us',
            'title' => "Complete Dental &\nAesthetic Care You Can Trust",
            'description' => 'From routine check-ups to smile makeovers and advanced aesthetic treatments, our experienced team combines modern technology with a gentle touch to give you the best care possible.',

            'doctor_name' => 'Dr. Gaganpreet Kaur',
            'doctor_title' => 'The Smile Design Specialist',
            'experience_years' => 18,
            'clinic_since' => '2008',

            'intro' => 'For nearly two decades, Dr. Gaganpreet Kaur has helped patients rediscover the confidence of a healthy, beautiful smile — blending advanced dentistry with true aesthetic artistry, all under one roof.',

            'body' => implode('', [
                '<h3>Advanced Dentistry & Aesthetic Artistry Under One Roof</h3>',
                '<p>At our clinic, dental health and facial aesthetics come together to deliver results that look natural and feel comfortable. Every treatment plan is designed around <em>you</em> — your goals, your comfort and your long-term oral health — using modern technology and time-tested clinical expertise.</p>',
                '<h3>Meet Dr. Gaganpreet Kaur</h3>',
                '<p>Fondly known as <strong>“The Smile Design Specialist,”</strong> Dr. Gaganpreet Kaur brings over <strong>18 years of clinical experience</strong> to every patient she treats. As an Oro Dental &amp; Aesthetic Expert and trained Cosmetologist, she is known for her gentle, patient-first approach and her meticulous eye for detail in cosmetic and restorative dentistry.</p>',
                '<p>Over the years she has honed her craft across some of the region’s respected institutions, including <strong>Sri Guru Ram Dass Dental Hospital, Amritsar</strong>, <strong>Satyam Hospital, Rohini (New Delhi)</strong> and <strong>Namdev Hospital, Ludhiana</strong> — experience that today informs the safe, precise and comfortable care she offers at our clinic.</p>',
                '<h3>A Practice Built on Trust — Since 2008</h3>',
                '<p>Established in 2008, our clinic has grown through the trust of thousands of families who return to us for everything from routine check-ups to complete smile makeovers. We believe that <strong>a beautiful smile is worth the wait</strong> — and that great dentistry should be painless, transparent and genuinely personal.</p>',
                '<p>From dental implants and clear aligners to teeth whitening, veneers and non-surgical facial aesthetics, we bring together the treatments that help you look and feel your very best.</p>',
            ]),

            'qualifications' => implode("\n", [
                'Oro Dental & Aesthetic Expert',
                'Cosmetologist',
                'FMC — Cosmetology',
                'FAM (USA)',
            ]),

            'philosophy' => 'A beautiful smile is worth the wait. Our promise is advanced dentistry and aesthetic artistry under one roof — delivered gently, honestly and always in your best interest.',

            'stat1_value' => '18+', 'stat1_label' => 'Years of Experience',
            'stat2_value' => '2008', 'stat2_label' => 'Trusted Since',
            'stat3_value' => '10,000+', 'stat3_label' => 'Smiles Created',
            'stat4_value' => '100%', 'stat4_label' => 'Personalised Care',
        ]);
    }

    protected function seedVideoTestimonials(): void
    {
        $samples = [
            [
                'heading' => 'A Life-Changing Dental Implants Journey',
                'notes' => 'Hear how full-mouth dental implants restored this patient’s ability to eat, smile and speak with confidence again. (Sample video — replace with your own patient stories from the admin panel.)',
                'youtube_url' => 'https://www.youtube.com/watch?v=-Oh9wXHckMY',
            ],
            [
                'heading' => 'Natural Smile Makeover with Veneers',
                'notes' => 'A patient shares her experience of a natural-looking smile transformation using porcelain veneers. (Sample video — replace from the admin panel.)',
                'youtube_url' => 'https://www.youtube.com/watch?v=b5TwmPPF4XY',
            ],
            [
                'heading' => 'Comfortable Care, Beautiful Results',
                'notes' => 'Paul shares his experience of gentle, comfortable treatment and the results that followed. (Sample video — replace from the admin panel.)',
                'youtube_url' => 'https://www.youtube.com/watch?v=LL4nu6Rz7Jo',
            ],
        ];

        foreach ($samples as $i => $s) {
            VideoTestimonial::firstOrCreate(
                ['heading' => $s['heading']],
                [
                    'notes' => $s['notes'],
                    'youtube_url' => $s['youtube_url'],
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }
    }
}
