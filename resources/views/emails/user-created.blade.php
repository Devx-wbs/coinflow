<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Coin Flow</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f9;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9;padding:30px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.05);">

                <!-- Header -->
                <tr>
                    <td style="background:#4e73df;padding:20px;text-align:center;">
                        <h2 style="color:#ffffff;margin:0;">Welcome to Coin Flow</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;color:#333333;">

                        <p style="font-size:16px;">Hello <strong>{{ $name }}</strong>,</p>

                        <p style="font-size:15px;line-height:1.6;">
                            Your account has been successfully created.
                            Below are your login details:
                        </p>

                        <table width="100%" cellpadding="8" cellspacing="0" style="margin:20px 0;background:#f8f9fc;border-radius:6px;">
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td>{{ ucfirst($role) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Password:</strong></td>
                                <td>{{ $password }}</td>
                            </tr>
                        </table>

                        <p style="font-size:14px;color:#666;">
                            For security reasons, please change your password after your first login.
                        </p>

                        <!-- Login Button -->
                        <div style="text-align:center;margin:30px 0;">
                            <a href="{{ url('/login') }}"
                               style="background:#4e73df;color:#ffffff;padding:12px 25px;text-decoration:none;border-radius:5px;font-size:15px;">
                                Login to Your Account
                            </a>
                        </div>

                        <p style="font-size:13px;color:#888;">
                            If the button does not work, copy and paste this link into your browser:
                        </p>
                        <p style="font-size:13px;color:#4e73df;">
                            {{ url('/login') }}
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f4f6f9;padding:15px;text-align:center;font-size:12px;color:#777;">
                        © {{ date('Y') }} Coin Flow. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
