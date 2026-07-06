<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplatesSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'key' => 'contact_confirmation',
                'name' => 'Contact Form — Confirmation to Visitor',
                'description' => 'Sent automatically to the person who submits the website contact form.',
                'subject' => 'We received your message · {{ company_name }}',
                'body' => '<p>Hi {{ name }},</p>'
                    . '<p>Thank you for getting in touch with {{ company_name }}. We have received your message and a member of our team will get back to you very soon.</p>'
                    . '<p><strong>Your message:</strong><br>{{ message }}</p>'
                    . '<p>Warm regards,<br>{{ company_name }} Team</p>',
            ],
            [
                'key' => 'contact_admin',
                'name' => 'Contact Form — Notification to Admin',
                'description' => 'Sent to the clinic inbox whenever a new contact form is submitted.',
                'subject' => 'New contact enquiry: {{ subject }}',
                'body' => '<p>A new enquiry has been submitted through the website contact form.</p>'
                    . '<p><strong>Name:</strong> {{ name }}<br>'
                    . '<strong>Email:</strong> {{ email }}<br>'
                    . '<strong>Phone:</strong> {{ phone }}<br>'
                    . '<strong>Subject:</strong> {{ subject }}</p>'
                    . '<p><strong>Message:</strong><br>{{ message }}</p>',
            ],
            [
                'key' => 'appointment_confirmation',
                'name' => 'Appointment Request — Confirmation to Patient',
                'description' => 'Sent automatically to the patient who requests an appointment on the website.',
                'subject' => 'We received your appointment request · {{ company_name }}',
                'body' => '<p>Hi {{ name }},</p>'
                    . '<p>Thank you for booking with {{ company_name }}. We have received your appointment request and our team will call you shortly to confirm your slot.</p>'
                    . '<p><strong>Requested treatment:</strong> {{ treatment }}<br>'
                    . '<strong>Preferred date:</strong> {{ preferred_date }}<br>'
                    . '<strong>Preferred time:</strong> {{ preferred_time }}</p>'
                    . '<p>Warm regards,<br>{{ company_name }} Team</p>',
            ],
            [
                'key' => 'appointment_admin',
                'name' => 'Appointment Request — Notification to Admin',
                'description' => 'Sent to the clinic inbox whenever a new appointment is requested on the website.',
                'subject' => 'New appointment request: {{ name }}',
                'body' => '<p>A new appointment has been requested through the website.</p>'
                    . '<p><strong>Name:</strong> {{ name }}<br>'
                    . '<strong>Phone:</strong> {{ phone }}<br>'
                    . '<strong>Email:</strong> {{ email }}<br>'
                    . '<strong>Treatment:</strong> {{ treatment }}<br>'
                    . '<strong>Preferred date:</strong> {{ preferred_date }}<br>'
                    . '<strong>Preferred time:</strong> {{ preferred_time }}</p>'
                    . '<p><strong>Message:</strong><br>{{ message }}</p>',
            ],
            [
                'key' => 'newsletter_welcome',
                'name' => 'Newsletter — Welcome Email',
                'description' => 'Sent to a visitor when they subscribe to the newsletter in the footer.',
                'subject' => 'Welcome to {{ company_name }}!',
                'body' => '<p>Hi there,</p>'
                    . '<p>Thanks for subscribing to the {{ company_name }} newsletter! You will be the first to hear about our latest offers, new treatments and oral health tips.</p>'
                    . '<p>Keep smiling,<br>{{ company_name }} Team</p>',
            ],
        ];

        foreach ($templates as $t) {
            EmailTemplate::firstOrCreate(['key' => $t['key']], $t);
        }
    }
}
