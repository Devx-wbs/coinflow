<!DOCTYPE html>
<html>

<head>
    <title>Plugin Update Available</title>
</head>

<body>

    <h2>New Plugin Version Released!</h2>

    <p>Hello,</p>

    <p>Your store is currently running an older plugin version.</p>

    <hr>

    <p><b>Store:</b> {{ $notice->store_url }}</p>

    <p><b>New Version:</b> {{ $notice->pluginVersion->version }}</p>

    <p><b>Release Date:</b>
        {{ $notice->pluginVersion->released_at->format('d M Y') }}
    </p>

    <hr>

    <p>Please update your plugin to the latest version for new features and security improvements.123</p>

    <a href="{{ route('update-tracker.download', $notice->pluginVersion->id) }}?license_key={{ $notice->license->license_key }}"
        style="background:#28a745;
          color:white;
          padding:10px 15px;
          text-decoration:none;
          border-radius:5px;">
        Download Latest Plugin ZIP
    </a>

    <br><br>

    <p>Thanks,<br>
        Plugin Support Team</p>

</body>

</html>