<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify your account</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f5f5f4;">

    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f5f5f4; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="500" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    
                    <tr>
                        <td style="padding: 30px; background-color: #134e4a; text-align: center;">
                            <span style="font-size: 24px; font-weight: 900; color: #ffffff; letter-spacing: 1px;">
                                Jama<span style="color: #d97706;">Welfare</span>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 30px;">
                            <h1 style="margin: 0 0 20px 0; font-size: 20px; color: #1c1917;">Verification Required</h1>
                            <p style="margin: 0 0 25px 0; font-size: 16px; color: #57534e; line-height: 1.5;">
                                Hello, thank you for registering with us. To complete your account setup, please use the verification code below:
                            </p>

                            <div style="background-color: #fef3c7; border: 1px solid #fcd34d; padding: 20px; text-align: center; border-radius: 8px; margin-bottom: 25px;">
                                <span style="display: block; font-size: 32px; font-weight: bold; color: #134e4a; letter-spacing: 6px;">
                                    {{ $otp }}
                                </span>
                            </div>

                            <p style="margin: 0; font-size: 14px; color: #78716c;">
                                This code will expire in <strong>30 minutes</strong>.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px; background-color: #fafaf9; border-top: 1px solid #e7e5e4; text-align: center;">
                            <p style="margin: 0 0 10px 0; font-size: 12px; color: #a8a29e;">
                                If you did not create an account with JamaWelfare, please ignore this email. No further action is required.
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #a8a29e;">
                                &copy; {{ date('Y') }} JamaWelfare. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>