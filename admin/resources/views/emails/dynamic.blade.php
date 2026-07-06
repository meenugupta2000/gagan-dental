<!doctype html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0; background:#f4f6fa; padding:24px; font-family:Arial,Helvetica,sans-serif; color:#333;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr><td align="center">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,.06);">
                <tr>
                    <td style="background:#2e7d32; padding:20px 28px; color:#fff; font-size:20px; font-weight:bold;">
                        {{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px; font-size:15px; line-height:1.7; color:#333;">
                        {!! $bodyHtml !!}
                    </td>
                </tr>
                <tr>
                    <td style="padding:16px 28px; background:#f4f6fa; color:#8893a5; font-size:12px;">
                        &copy; {{ date('Y') }} {{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}. All rights reserved.
                    </td>
                </tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
