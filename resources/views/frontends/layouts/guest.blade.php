<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }} - Synbio</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('frontends/assets/favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontends/css/bootstrap.min.css') }}">

    <!-- Bootstrap JS -->
    <script src="{{ asset('frontends/js/bootstrap.bundle.min.js') }}"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('frontends/style.css') }}">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    @yield('content')
</body>

</html>