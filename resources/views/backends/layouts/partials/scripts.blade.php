<script src="{{ asset('backends/assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('backends/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>


<script src="{{ asset('backends/assets/compiled/js/app.js') }}"></script>

<!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Need: Apexcharts -->
{{-- <script src="{{ asset('backends/assets/extensions/apexcharts/apexcharts.min.js') }}"></script> --}}
<script src="{{ asset('backends/assets/static/js/pages/dashboard.js') }}"></script>


<!-- Need: Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custome JS -->
@stack('js')
