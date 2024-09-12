<!-- resources/views/pages/attendances/check-in/qr-code.blade.php -->
<div class="container">
    <div class="row g-3"> <!-- g-3 menambahkan jarak antar kolom -->
        @foreach ($employees as $employee)
            <div class="col-md-3 text-center"> <!-- Atur lebar kolom sesuai kebutuhan -->

                <h5 class="">{{ $employee->name }}</h5>
                @if ($employee->qrCode->data)
                    {!! $employee->qrCode->data !!}
                @endif
            </div>
        @endforeach
    </div>
</div>
