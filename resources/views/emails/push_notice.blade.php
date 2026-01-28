<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $notification->title }}</title>
</head>
<body>
    <h2>{{ $notification->title }}</h2>

    <p>
        {!! nl2br(e($notification->message)) !!}
    </p>

    <hr>
    <small>
        This is an automated notification from {{ config('app.name') }}.
    </small>
</body>
</html>
