@extends('layouts.app', ['dt' => true])
@section('content')
    <div class="mySweet" data-create="{{ session('success') }}"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bold text-primary">{{ $title }}</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"></table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        var _URL = "{{ route('datatable.attendances.daily') }}"
        var _COLUMNS = [{
                title: '#',
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                title: '{{ __('Name') }}',
                data: 'name',
                className: "text-capitalize"
            },
            {
                title: '{{ __('Come') }}',
                data: 'clock_in',
                className: "text-capitalize"
            },
            {
                title: '{{ __('Come Home') }}',
                data: 'clock_out',
                className: "text-capitalize"
            },
            {
                title: '{{ __('Leave Request') }}',
                data: 'leave_request',
                className: "text-capitalize"
            },
        ];

        var _DATATABLE = setDataTable(_URL, _COLUMNS);
    </script>
@endpush
