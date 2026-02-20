<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Support Ticket Reply</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0d6efd; padding:20px; text-align:center; color:#ffffff;">
                            <h2 style="margin:0;">Support Ticket Update</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px; color:#333;">

                            <p>Hi <strong>{{ $support->full_name }}</strong>,</p>

                            <p>Your support ticket has been updated. Below are the details:</p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="margin:20px 0; border-collapse:collapse;">

                                <tr style="background:#f8f9fa;">
                                    <td><strong>Ticket ID:</strong></td>
                                    <td>TK-{{ str_pad($support->id, 3, '0', STR_PAD_LEFT) }}</td>
                                </tr>

                                <tr>
                                    <td><strong>Subject:</strong></td>
                                    <td>{{ $support->subject }}</td>
                                </tr>

                                <tr style="background:#f8f9fa;">
                                    <td><strong>Your Email:</strong></td>
                                    <td>{{ $support->email }}</td>
                                </tr>

                            </table>

                            <h4 style="margin-bottom:10px;">Reply Message:</h4>

                            <div style="background:#f1f3f5; padding:15px; border-radius:6px;">
                                {{ $reply->message }}
                            </div>

                            <p style="margin-top:25px;">
                                If you require additional help, please contact our support helpline
                            </p>
                            <p>
                                <strong>Support Helpline:</strong><br>
                                Email: <a href="mailto:support@coinflow.com">support@coinflow.com</a><br>
                                Phone: +1 (555) 123-4567
                            </p>
                            <p>Our team will be happy to assist you.</p>

                            <p>
                                Regards,<br>
                                <strong>CoinFlow Support Team</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8f9fa; padding:15px; text-align:center; font-size:12px; color:#666;">
                            © {{ date('Y') }} CoinFlow. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>