@extends('layouts.app', ['dt' => true])
@section('content')
    <h1 class="h3 mb-2 text-gray-800">{{ $title }}</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('List of Leave Types') }}</h6>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalForm">
                <i class="fas fa-plus"></i> {{ __('Add Type Of Leave') }}
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"></table>
            </div>
        </div>
    </div>
@widget('modal', ['title' => __($title), 'form' => 'pages.leave-request.type-of-leave.form', 'data' => [], 'type' => ''])
@widget('delete',['dt'=> true])
@endsection
@push('js')
    <script>
           var _URL = "{{ route('datatable.type-of-leave') }}"
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
                title: '{{ __('Action') }}',
                data: 'action',
            },
        ];

        var _DATATABLE = setDataTable(_URL, _COLUMNS);
          $("#btn-submit").click(function(e) {
            e.preventDefault();
            var form = $("#type-of-leave-form");
            saveForm(form, form.attr('action'), $('#modalForm'), 'POST', true);
        })
        function attactEdit(modal, response) {
            modal.find("input[name=id]").val(response.data.id);
            modal.find("input[name=name]").val(response.data?.name);
        }
    </script>
@endpush
