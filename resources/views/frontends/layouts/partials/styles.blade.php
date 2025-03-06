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

<!-- Custome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
@stack('css')

<!-- Custome JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('assets/js/cart.js') }}"></script>
@stack('js')
