<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Models\ContactMessage;
use App\Models\EmailTemplate;
use App\Support\FormShield;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /** Public contact page (form + company contact info). */
    public function show(Request $request)
    {
        return view('contact');
    }

    /** Handle a contact-form submission. */
    public function submit(Request $request)
    {
        // Spam guard (honeypot + timing). Silently pretend success so bots
        // don't learn they were blocked; the message is simply not saved/sent.
        if (! FormShield::passes($request)) {
            return redirect()->route('contact')
                ->with('success', 'Thank you! Your message has been sent — we will get back to you shortly.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[\pL][\pL .\'\-]*$/u'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{7,30}$/'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ], [
            'name.regex' => 'Name can only contain letters, spaces, . \' and -',
            'phone.regex' => 'Please enter a valid phone number.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        $message = ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
        ]);

        $this->sendEmails($message);

        return redirect()->route('contact')
            ->with('success', 'Thank you! Your message has been sent — we will get back to you shortly.');
    }

    /** Send confirmation (to sender) + notification (to admin) if SMTP is configured. */
    private function sendEmails(ContactMessage $message): void
    {
        $company = CompanyInfo::current();

        if (! $company->mail_host) {
            return; // Email not configured yet — silently skip.
        }

        // Values for the {{ placeholders }} — raw for the subject, HTML-safe for the body.
        $subjectData = [
            'name' => $message->name,
            'email' => $message->email,
            'phone' => $message->phone ?: '',
            'subject' => $message->subject ?: 'No subject',
            'company_name' => $company->company_name ?: 'Gagan Dental & Aesthetics Clinic',
        ];
        $bodyData = array_map(fn ($v) => e($v), $subjectData);
        $bodyData['message'] = nl2br(e($message->message));
        $subjectData['message'] = $message->message;

        try {
            $this->configureMailer($company);

            // Confirmation to the person who filled the form.
            $confirm = EmailTemplate::active('contact_confirmation');
            if ($confirm) {
                $subject = EmailTemplate::renderText($confirm->subject, $subjectData);
                $bodyHtml = EmailTemplate::renderText($confirm->body, $bodyData);
                Mail::send('emails.dynamic', ['bodyHtml' => $bodyHtml, 'company' => $company], function ($mail) use ($message, $subject) {
                    $mail->to($message->email, $message->name)->subject($subject);
                });
            } else {
                Mail::send('emails.contact_confirmation', ['msg' => $message, 'company' => $company], function ($mail) use ($message, $company) {
                    $mail->to($message->email, $message->name)
                        ->subject('We received your message · ' . ($company->company_name ?: 'Gagan Dental & Aesthetics Clinic'));
                });
            }

            // Notification to the admin.
            $adminEmail = $company->email ?: $company->mail_from_address ?: $company->mail_username;
            if ($adminEmail) {
                $notify = EmailTemplate::active('contact_admin');
                if ($notify) {
                    $subject = EmailTemplate::renderText($notify->subject, $subjectData);
                    $bodyHtml = EmailTemplate::renderText($notify->body, $bodyData);
                    Mail::send('emails.dynamic', ['bodyHtml' => $bodyHtml, 'company' => $company], function ($mail) use ($adminEmail, $message, $subject) {
                        $mail->to($adminEmail)->replyTo($message->email, $message->name)->subject($subject);
                    });
                } else {
                    Mail::send('emails.contact_admin', ['msg' => $message, 'company' => $company], function ($mail) use ($adminEmail, $message) {
                        $mail->to($adminEmail)
                            ->replyTo($message->email, $message->name)
                            ->subject('New contact enquiry: ' . ($message->subject ?: 'No subject'));
                    });
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Contact form email failed: ' . $e->getMessage());
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

        // Drop any already-resolved smtp mailer so it picks up the new config.
        Mail::purge('smtp');
    }
}
