   <!-- Bootstrap core JavaScript-->
   <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
   <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <!-- Core plugin JavaScript-->
   <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
   <!-- Custom scripts for all pages-->
   <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- Page level custom scripts -->
   @if (isset($dt))
       <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
       <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
       @widget('datatable')
   @endif
   <script>
       var translations = {
           "failed": "{{ __('Failed') }}",
           "success": "{{ __('Success') }}"
       }
   </script>
   <script src="{{ asset('vendor/iziToast/iziToast.min.js') }}"></script>
   <script src="{{ asset('js/support/loading.js') }}"></script>
   <script src="{{ asset('js/support/save.js') }}"></script>
   <script src="{{ asset('js/support/custom.js') }}"></script>
   <script src="{{ asset('js/support/moment.min.js') }}"></script>
   <script>
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
       });
       $("#logout").click(function(e) {
           e.preventDefault();
           var href = $(this).attr("href");
           Swal.fire({
               title: "{{ __('Are You Sure?') }}",
               text: "{{ __('You Will End This Session') }}",
               icon: "warning",
               showClass: {
                   popup: `animate__animated
                        animate__zoomIn
                        animate__faster`
               },
               hideClass: {
                   popup: `animate__animated
                        animate__zoomOut
                        animate__faster`
               },
               showCancelButton: true,
               confirmButtonColor: "#4e73df",
               cancelButtonColor: "#da5643",
               confirmButtonText: "{{ __('Yes') }}",
               cancelButtonText: "{{ __('No') }}"
           }).then((result) => {
               if (result.isConfirmed) {
                   window.location.href = href;
               }
           });
       });
   </script>
   @stack('js')
   @vite('resources/js/app.js')
