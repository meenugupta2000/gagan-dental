<!DOCTYPE html>
<html>
<body style="margin:0;background:#f4f6fb;font-family:Arial,Helvetica,sans-serif;color:#36435a;">
    <div style="max-width:560px;margin:24px auto;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #e8ecf3;">
        <div style="background:#2e7d32;padding:20px 28px;color:#fff;">
            <h1 style="margin:0;font-size:18px;">New contact enquiry</h1>
        </div>
        <div style="padding:28px;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <tr><td style="padding:7px 0;color:#8893a5;width:90px;">Name</td><td style="padding:7px 0;font-weight:bold;">{{ $msg->name }}</td></tr>
                <tr><td style="padding:7px 0;color:#8893a5;">Email</td><td style="padding:7px 0;"><a href="mailto:{{ $msg->email }}" style="color:#2e7d32;">{{ $msg->email }}</a></td></tr>
                @if ($msg->phone)
                <tr><td style="padding:7px 0;color:#8893a5;">Phone</td><td style="padding:7px 0;">{{ $msg->phone }}</td></tr>
                @endif
                @if ($msg->subject)
                <tr><td style="padding:7px 0;color:#8893a5;">Subject</td><td style="padding:7px 0;">{{ $msg->subject }}</td></tr>
                @endif
                <tr><td style="padding:7px 0;color:#8893a5;vertical-align:top;">Message</td><td style="padding:7px 0;white-space:pre-line;">{{ $msg->message }}</td></tr>
            </table>
            <p style="margin:20px 0 0;font-size:13px;color:#9aa6b8;">Reply directly to this email to respond to {{ $msg->name }}.</p>
        </div>
    </div>
</body>
</html>
