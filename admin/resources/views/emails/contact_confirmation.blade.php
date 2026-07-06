<!DOCTYPE html>
<html>
<body style="margin:0;background:#f4f6fb;font-family:Arial,Helvetica,sans-serif;color:#36435a;">
    <div style="max-width:560px;margin:24px auto;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf3;">
        <div style="background:#0d1b2a;padding:22px 28px;color:#fff;">
            <h1 style="margin:0;font-size:20px;">{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}</h1>
        </div>
        <div style="padding:28px;">
            <h2 style="margin:0 0 12px;font-size:18px;color:#14233a;">Thank you, {{ $msg->name }}!</h2>
            <p style="margin:0 0 16px;line-height:1.6;">We've received your message and our team will get back to you shortly. Here's a copy of what you sent:</p>
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                @if ($msg->subject)
                <tr><td style="padding:6px 0;color:#8893a5;width:90px;">Subject</td><td style="padding:6px 0;">{{ $msg->subject }}</td></tr>
                @endif
                <tr><td style="padding:6px 0;color:#8893a5;vertical-align:top;">Message</td><td style="padding:6px 0;white-space:pre-line;">{{ $msg->message }}</td></tr>
            </table>
            <p style="margin:22px 0 0;line-height:1.6;color:#647089;">Warm regards,<br>The {{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }} Team</p>
        </div>
        <div style="padding:16px 28px;background:#f9fafc;color:#9aa6b8;font-size:12px;text-align:center;">
            @if ($company->phone) {{ $company->phone }} &nbsp;·&nbsp; @endif
            @if ($company->email) {{ $company->email }} @endif
        </div>
    </div>
</body>
</html>
