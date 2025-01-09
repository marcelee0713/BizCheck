<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Change Verification</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.5; padding: 20px; background-color: #f4f7fc;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; padding: 20px;">
        <tr>
            <td style="text-align: center; padding-bottom: 20px;">
                <h2 style="color: #4CAF50;">Hello, {{ $user->name }}!</h2>
            </td>
        </tr>
        <tr>
            <td>
                <p>We received a request to change your email address on BizCheck. Please click the button below to verify your new email address.</p>
                <p style="text-align: center;">
                    <a href="{{ $link }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px; text-decoration: none;">
                        Verify Email Address
                    </a>
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding-top: 20px;">
                <p>If you did not request this email change, no further action is required. Your email address will remain unchanged.</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding-top: 20px;">
                <p>If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:</p>
                <p><a href="{{ $link }}">{{ $link }}</a></p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding-top: 30px;">
                <p>Regards,<br>BizCheck</p>
                <p>&copy; {{ date('Y') }} BizCheck. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
