<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Models\EmailTemplate;
use App\Models\Subscriber;
use App\Support\FormShield;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    /**
     * Store a newsletter subscription from the public footer form.
     */
    public function store(Request $request)
    {
        // Spam guard (honeypot + timing). Silently pretend success so bots
        // don't learn they were blocked; the address is simply not saved.
        if (! FormShield::passes($request, 2)) {
            return response()->json(['message' => 'Thanks for subscribing!']);
        }

        $data = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ], [
            'email.email' => 'Please enter a valid email address.',
        ]);

        $subscriber = Subscriber::firstOrCreate([
            'email' => strtolower(trim($data['email'])),
        ]);

        // Send the welcome email only for brand-new subscribers.
        if ($subscriber->wasRecentlyCreated) {
            $this->sendWelcome($subscriber->email);
        }

        return response()->json([
            'message' => $subscriber->wasRecentlyCreated
                ? 'Thanks for subscribing!'
                : "You're already subscribed.",
        ]);
    }

    /** Send the newsletter welcome email if SMTP is configured and the template is active. */
    private function sendWelcome(string $email): void
    {
        $company = CompanyInfo::current();

        if (! $company->mail_host) {
            return; // Email not configured — silently skip.
        }

        $template = EmailTemplate::active('newsletter_welcome');
        if (! $template) {
            return;
        }

        $bodyData = [
            'email' => e($email),
            'company_name' => e($company->company_name ?: 'Gagan Dental & Aesthetics Clinic'),
        ];
        $subjectData = [
            'email' => $email,
            'company_name' => $company->company_name ?: 'Gagan Dental & Aesthetics Clinic',
        ];

        try {
            $this->configureMailer($company);

            $subject = EmailTemplate::renderText($template->subject, $subjectData);
            $bodyHtml = EmailTemplate::renderText($template->body, $bodyData);

            Mail::send('emails.dynamic', ['bodyHtml' => $bodyHtml, 'company' => $company], function ($mail) use ($email, $subject) {
                $mail->to($email)->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::warning('Newsletter welcome email failed: ' . $e->getMessage());
        }
    }

    /** Apply the SMTP settings stored in Company Info to the mailer for this request. */
    private function configureMailer(CompanyInfo $company): void
    {
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => $company->mail_host,
            'mail.mailers.smtp.port' => (int) ($company->mail_port ?: 587),
            'mail.mailers.smtp.username' => $company->mail_username,
            'mail.mailers.smtp.password' => $company->mail_password,
            'mail.mailers.smtp.encryption' => $company->mail_encryption ?: null,
            'mail.from.address' => $company->mail_from_address ?: ($company->mail_username ?: 'no-reply@localhost'),
            'mail.from.name' => $company->mail_from_name ?: ($company->company_name ?: 'Gagan Dental & Aesthetics Clinic'),
        ]);

        Mail::purge('smtp');
    }
}
