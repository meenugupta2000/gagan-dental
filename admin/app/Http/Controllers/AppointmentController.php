<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CompanyInfo;
use App\Models\EmailTemplate;
use App\Models\Treatment;
use App\Support\FormShield;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    /** Public "Book an Appointment" page (form + treatment suggestions). */
    public function create()
    {
        // Passed to the form as datalist suggestions for the free-text treatment box.
        $treatments = Treatment::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('appointment', compact('treatments'));
    }

    /** Handle an appointment-form submission. */
    public function store(Request $request)
    {
        // Spam guard (honeypot + timing). Silently pretend success so bots
        // don't learn they were blocked; the request is simply not saved/sent.
        if (! FormShield::passes($request)) {
            return redirect()->route('appointment')
                ->with('success', 'Thank you! Your appointment request has been received — our team will contact you shortly to confirm.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'treatment_name' => ['nullable', 'string', 'max:255'],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'preferred_time' => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $appointment = Appointment::create($data); // status defaults to 'new'

        $this->sendEmails($appointment);

        return redirect()->route('appointment')
            ->with('success', 'Thank you! Your appointment request has been received — our team will contact you shortly to confirm.');
    }

    /** Admin list of appointment requests (filterable by status, searchable). */
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $status = $request->string('status')->toString();
        if (! in_array($status, Appointment::STATUSES, true)) {
            $status = '';
        }

        $appointments = Appointment::query()
            ->with('treatment')
            ->when($q, fn ($query) => $query->where(fn ($w) => $w
                ->where('name', 'like', "%{$q}%")
                ->orWhere('phone', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.appointments.index', compact('appointments', 'status', 'q'));
    }

    /** Admin single-appointment detail page. */
    public function show(Appointment $appointment)
    {
        $appointment->load('treatment');

        return view('admin.appointments.show', compact('appointment'));
    }

    /** Move an appointment through its workflow (new → contacted → …). */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(Appointment::STATUSES)],
        ]);

        $appointment->update($data);

        return back()->with('success', 'Appointment marked as ' . ucfirst($data['status']) . '.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /** Send notification (to clinic) + confirmation (to patient) if SMTP is configured. */
    private function sendEmails(Appointment $appointment): void
    {
        $company = CompanyInfo::current();

        if (! $company->mail_host) {
            return; // Email not configured yet — silently skip.
        }

        // Values for the {{ placeholders }} — raw for the subject, HTML-safe for the body.
        $subjectData = [
            'name' => $appointment->name,
            'phone' => $appointment->phone,
            'email' => $appointment->email ?: '—',
            'treatment' => $appointment->treatment_label ?: '—',
            'preferred_date' => $appointment->preferred_date?->format('d M Y') ?: '—',
            'preferred_time' => $appointment->preferred_time ?: '—',
            'company_name' => $company->company_name ?: 'Gagan Dental & Aesthetics Clinic',
        ];
        $bodyData = array_map(fn ($v) => e($v), $subjectData);
        $bodyData['message'] = nl2br(e($appointment->message ?: '—'));
        $subjectData['message'] = $appointment->message ?: '—';

        try {
            $this->configureMailer($company);

            // Notification to the clinic inbox.
            $adminEmail = $company->email ?: $company->mail_from_address ?: $company->mail_username;
            $notify = EmailTemplate::active('appointment_admin');
            if ($adminEmail && $notify) {
                $subject = EmailTemplate::renderText($notify->subject, $subjectData);
                $bodyHtml = EmailTemplate::renderText($notify->body, $bodyData);
                Mail::send('emails.dynamic', ['bodyHtml' => $bodyHtml, 'company' => $company], function ($mail) use ($adminEmail, $appointment, $subject) {
                    $mail->to($adminEmail)->subject($subject);
                    if ($appointment->email) {
                        $mail->replyTo($appointment->email, $appointment->name);
                    }
                });
            }

            // Confirmation to the patient (only when they left an email address).
            $confirm = EmailTemplate::active('appointment_confirmation');
            if ($appointment->email && $confirm) {
                $subject = EmailTemplate::renderText($confirm->subject, $subjectData);
                $bodyHtml = EmailTemplate::renderText($confirm->body, $bodyData);
                Mail::send('emails.dynamic', ['bodyHtml' => $bodyHtml, 'company' => $company], function ($mail) use ($appointment, $subject) {
                    $mail->to($appointment->email, $appointment->name)->subject($subject);
                });
            }
        } catch (\Throwable $e) {
            Log::warning('Appointment email failed: ' . $e->getMessage());
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
