<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>New User Created</h2>

    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>

    <br>
    <p>— LayerLoop System</p>
</body>
</html>
