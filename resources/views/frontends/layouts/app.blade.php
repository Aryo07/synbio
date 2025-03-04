<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SynBio - Belanja Buah & Sayur</title>

    @include('frontends.layouts.partials.styles')
</head>

<body>
    <!-- navbar -->
    @include('frontends.layouts.partials.navbar')
    <!--navbar -->

    @yield('content')

    <!-- footer -->
    @include('frontends.layouts.partials.footer')
    <!-- footer -->
</body>

</html>
