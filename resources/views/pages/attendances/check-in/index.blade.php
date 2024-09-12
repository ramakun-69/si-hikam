@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">{{ __('Check In') }}</h1>
    <div class="card shadow mb-4">
        <div id="loading" class="d-none">
            <div class="d-flex align-items-center justify-content-center mt-5">
                <div class="d-flex align-items-center">
                    <div class="spinner-border text-primary" style="width: 50px; height: 50px;" role="status" id="spinner"></div>
                </div>
            </div>
        </div>
        <div class="card-body" id="qr">
            <!-- QR codes akan ditambahkan di sini -->
        </div>
    </div>
@endsection

@push('js')
    <script>
        function showLoading() {
            $("#loading").removeClass('d-none');
          
        }

        function hideLoading() {
            $("#loading").addClass('d-none');
            // $("#spinner").addClass('d-none');
        }

        function getQr() {
            $.ajax({
                type: "GET",
                url: "{{ route('get-qr') }}",
                dataType: "json",
                beforeSend: function() {
                    showLoading();
                },
                success: function(response) {
                    $("#qr").append(response);
                    hideLoading();
                },
                error: function() {
                    hideLoading();
                    console.error('Terjadi kesalahan saat memuat QR code');
                }
            });
        }

        $(document).ready(function() {
            getQr();
        });
    </script>
@endpush
