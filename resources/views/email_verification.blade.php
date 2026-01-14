<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h1>Verify Your Email Address</h1>
    <p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
        Before accessing your account, please check your email for a verification link.
        If you did not receive the email, <button type="submit">Resend Verification Email</button>
        click here to request another</a>.
    </form>
    </p>

    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
</body>
</html>
