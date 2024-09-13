
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<!-- Custom scripts for all pages-->
<script>
    var translations = {
        "failed": "{{ __('Failed') }}",
        "success": "{{ __('Success') }}"
    }
</script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('vendor/iziToast/iziToast.min.js') }}"></script>
<script src="{{ asset('js/support/loading.js') }}"></script>
<script src="{{ asset('js/support/save.js') }}"></script>
<script src="{{ asset('js/support/custom.js') }}"></script>
<script src="{{ asset('js/support/moment.min.js') }}"></script>
<!-- Bootstrap core JavaScript-->
@stack('js')