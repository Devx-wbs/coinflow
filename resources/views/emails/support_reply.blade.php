<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Support Reply</title>
</head>
<body>
    <h3>Support Ticket Update</h3>

    <p>
        <strong>Ticket ID:</strong>
        TK-{{ str_pad($support->id, 3, '0', STR_PAD_LEFT) }}
    </p>

    <p>
        <strong>Subject:</strong>
        {{ $support->subject }}
    </p>

    <hr>

    <p>{{ $reply->message }}</p>

    <hr>

    <p>
        Regards,<br>
        <strong>Support Team</strong>
    </p>
</body>
</html>
