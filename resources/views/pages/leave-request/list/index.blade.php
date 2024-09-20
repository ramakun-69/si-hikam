@extends('layouts.app', ['dt' => true])
@section('content')
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
        var _URL = "{{ route('datatable.leave-request.list') }}"
        var _COLUMNS = [{
                title: '#',
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                title: '{{ __('Name') }}',
                data: 'employee',
                className: "text-capitalize"
            },
            {
                title: '{{ __("Type Of Leave") }}',
                data: 'type',
                className: "text-capitalize"
            },
            {
                title: '{{ __('Date') }}',
                data: 'date',
                className: "text-capitalize"
            },
            {
                title: '{{ __('Time') }}',
                data: 'time',
                className: "text-capitalize"
            },
        ];

        var _DATATABLE = setDataTable(_URL, _COLUMNS);
    </script>
@endpush
