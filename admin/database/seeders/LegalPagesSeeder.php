<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

/**
 * Adds standard "Privacy Policy" and "Terms & Conditions" pages with the exact
 * slugs the footer links to. Uses firstOrCreate so it never overwrites content
 * the admin may have already written. The wording is a professional starting
 * template for a dental & aesthetics clinic — it should be reviewed and adapted
 * (clinic details, jurisdiction) and is not a substitute for legal advice.
 */
class LegalPagesSeeder extends Seeder
{
    public function run(): void
    {
        Page::firstOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Privacy Policy',
                'is_active' => true,
                'content' => $this->privacyPolicy(),
            ]
        );

        Page::firstOrCreate(
            ['slug' => 'terms-conditions'],
            [
                'title' => 'Terms & Conditions',
                'is_active' => true,
                'content' => $this->termsConditions(),
            ]
        );
    }

    private function privacyPolicy(): string
    {
        return <<<'HTML'
<p><em>Last updated: July 2026</em></p>

<p>Gagan Dental &amp; Aesthetics Clinic ("we", "us" or "our") respects your privacy and is committed to protecting the personal information you share with us. This Privacy Policy explains what information we collect through this website, how we use it, and the choices you have. By using this website or submitting your details through it, you agree to the practices described below.</p>

<h3>1. Information We Collect</h3>
<p><strong>Information you provide to us.</strong> When you fill in a form on our website — such as the contact form, the appointment request form, or the newsletter sign-up — we may collect:</p>
<ul>
    <li>Your name;</li>
    <li>Your phone number and/or email address;</li>
    <li>The treatment or service you are interested in and your preferred date/time;</li>
    <li>Any message or details you choose to include; and</li>
    <li>Your email address, if you subscribe to updates.</li>
</ul>
<p><strong>Information collected automatically.</strong> Like most websites, we may automatically collect limited technical information such as your browser type, device information, approximate location and pages visited, using cookies and similar technologies (see "Cookies" below).</p>

<h3>2. Health-Related Information</h3>
<p>Please do not submit detailed medical or health information through the website forms. Any information you share about a treatment you are interested in is used only to respond to your enquiry and prepare for your visit. Your clinical records are created and kept securely at the clinic, separately from this website.</p>

<h3>3. How We Use Your Information</h3>
<ul>
    <li>To respond to your enquiries and contact you about your request;</li>
    <li>To schedule, confirm and manage your appointment;</li>
    <li>To send you information, offers or updates you have requested;</li>
    <li>To improve our website, services and patient experience; and</li>
    <li>To comply with our legal and regulatory obligations.</li>
</ul>

<h3>4. How We Share Your Information</h3>
<p>We do not sell or rent your personal information. We may share it only:</p>
<ul>
    <li>With trusted service providers who help us operate our website and communications (for example, hosting or email delivery), under confidentiality obligations;</li>
    <li>Where required by law, regulation or a valid legal request; and</li>
    <li>To protect the rights, safety or property of our patients, staff or clinic.</li>
</ul>

<h3>5. Cookies &amp; Analytics</h3>
<p>Our website may use cookies and similar technologies to make the site work, remember your preferences and understand how the site is used. You can control or delete cookies through your browser settings. Some parts of the site may not function properly if cookies are disabled.</p>

<h3>6. Third-Party Links &amp; Services</h3>
<p>Our website may contain links to, or content from, third-party services such as WhatsApp, YouTube, Google Maps or social media. When you use those services you are subject to their own privacy policies, over which we have no control. We encourage you to review them.</p>

<h3>7. Data Security</h3>
<p>We take reasonable technical and organisational measures to protect your information against loss, misuse or unauthorised access. However, no method of transmission over the internet is completely secure, and we cannot guarantee absolute security.</p>

<h3>8. Data Retention</h3>
<p>We keep your information only for as long as necessary to fulfil the purposes described in this policy, to provide our services, and to meet legal or regulatory requirements, after which it is securely deleted or anonymised.</p>

<h3>9. Your Rights</h3>
<p>Subject to applicable law, you may request to access, correct, update or delete the personal information we hold about you, or ask us to stop sending you marketing messages. To make a request, please contact us using the details on our <a href="/contact">Contact</a> page.</p>

<h3>10. Children's Privacy</h3>
<p>Our website is not directed at children, and we do not knowingly collect personal information from children without the consent of a parent or guardian. Appointments for minors should be arranged by a parent or guardian.</p>

<h3>11. Changes to This Policy</h3>
<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised "Last updated" date. Please review it periodically.</p>

<h3>12. Contact Us</h3>
<p>If you have any questions about this Privacy Policy or how your information is handled, please reach out to us through our <a href="/contact">Contact</a> page or the phone numbers listed on our website.</p>
HTML;
    }

    private function termsConditions(): string
    {
        return <<<'HTML'
<p><em>Last updated: July 2026</em></p>

<p>Welcome to the website of Gagan Dental &amp; Aesthetics Clinic ("we", "us" or "our"). These Terms &amp; Conditions govern your use of this website. By accessing or using the website, you agree to be bound by these terms. If you do not agree, please do not use the website.</p>

<h3>1. Informational Purpose Only</h3>
<p>The content on this website — including information about treatments, procedures and aesthetics — is provided for general informational purposes only. It is not intended to be, and should not be relied upon as, medical or dental advice, diagnosis or treatment. Always seek the advice of a qualified dentist or healthcare professional regarding your specific condition.</p>

<h3>2. No Doctor–Patient Relationship</h3>
<p>Using this website, submitting a form or contacting us through it does not create a doctor–patient or professional relationship. Such a relationship is established only after an in-person consultation and examination at the clinic.</p>

<h3>3. Appointments &amp; Bookings</h3>
<ul>
    <li>An appointment request submitted through the website is a <strong>request only</strong> and is not confirmed until our team contacts you to arrange and confirm a date and time.</li>
    <li>We will make reasonable efforts to accommodate your preferred slot, but availability is not guaranteed.</li>
    <li>Please inform us in advance if you need to reschedule or cancel, so we can offer the time to other patients.</li>
</ul>

<h3>4. Treatments, Fees &amp; Results</h3>
<p>Details of any treatment, its suitability for you, and the applicable fees are provided during an in-person consultation, as they depend on your individual needs and clinical assessment. Any results, testimonials or images shown on this website are for illustration only; individual results vary from person to person and cannot be guaranteed.</p>

<h3>5. Intellectual Property</h3>
<p>All content on this website — including text, graphics, logos, images and design — is owned by or licensed to Gagan Dental &amp; Aesthetics Clinic and is protected by applicable intellectual property laws. You may not copy, reproduce, distribute or use any content without our prior written permission.</p>

<h3>6. Acceptable Use</h3>
<p>You agree to use this website lawfully and not to:</p>
<ul>
    <li>Attempt to gain unauthorised access to the website or its systems;</li>
    <li>Interfere with or disrupt the website's operation or security;</li>
    <li>Submit false, misleading or unlawful information; or</li>
    <li>Use the website in any way that infringes the rights of others.</li>
</ul>

<h3>7. Third-Party Links &amp; Content</h3>
<p>This website may contain links to third-party websites or services (such as WhatsApp, YouTube, Google Maps or social media). We are not responsible for the content, policies or practices of those third parties, and links do not imply our endorsement.</p>

<h3>8. Testimonials &amp; Reviews</h3>
<p>Testimonials and reviews reflect the personal experiences and opinions of individual patients. They are not a guarantee that you will experience the same outcome.</p>

<h3>9. Disclaimer</h3>
<p>This website is provided on an "as is" and "as available" basis, without warranties of any kind, whether express or implied. We do not warrant that the website will be uninterrupted, error-free, or free of viruses or other harmful components, and we may modify or discontinue any part of it at any time without notice.</p>

<h3>10. Limitation of Liability</h3>
<p>To the fullest extent permitted by law, Gagan Dental &amp; Aesthetics Clinic shall not be liable for any indirect, incidental or consequential loss or damage arising from your use of, or inability to use, this website or any information on it.</p>

<h3>11. Privacy</h3>
<p>Your use of this website is also governed by our <a href="/page/privacy-policy">Privacy Policy</a>, which explains how we collect and handle your information.</p>

<h3>12. Governing Law</h3>
<p>These Terms &amp; Conditions are governed by and construed in accordance with the laws of India, and any disputes shall be subject to the exclusive jurisdiction of the courts having jurisdiction over the location of the clinic.</p>

<h3>13. Changes to These Terms</h3>
<p>We may update these Terms &amp; Conditions from time to time. Any changes take effect once posted on this page with a revised "Last updated" date. Your continued use of the website constitutes acceptance of the updated terms.</p>

<h3>14. Contact Us</h3>
<p>If you have any questions about these Terms &amp; Conditions, please contact us through our <a href="/contact">Contact</a> page or the phone numbers listed on our website.</p>
HTML;
    }
}
