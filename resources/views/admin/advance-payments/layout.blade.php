<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Advance Payments')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('advance-received.index') }}">Advance Payments</a>
        <div class="navbar-nav">
            <a class="nav-link" href="{{ route('advance-received.index') }}">Received</a>
            <a class="nav-link" href="{{ route('advance-paid.index') }}">Paid</a>
            <a class="nav-link" href="{{ route('advance-parties.index') }}">Parties</a>
        </div>
    </div>
</nav>
<main class="container pb-5">
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
</main>
</body>
</html>
