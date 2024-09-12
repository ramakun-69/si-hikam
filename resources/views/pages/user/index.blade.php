@extends('layouts.app', ['dt' => true])
@section('content')
    <div class="mySweet" data-create="{{ session('success') }}"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bold text-primary">{{ __("User Data") }}</h6>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalForm">
                <i class="fas fa-plus"></i> {{ __('Add User') }}
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"></table>
            </div>
        </div>
    </div>
    @widget('modal', ['title' => __($title), 'form' => 'pages.user.form', 'data' => [], 'type' => 'modal-lg'])
    @widget('delete',['dt'=> true])
@endsection
@push('js')
    <script>
           var _URL = "{{ route('datatable.users') }}"
        var _COLUMNS = [{
                title: '#',
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                title: '{{ __('Name') }}',
                data: 'employee.name',
                className: "text-capitalize"
            },
            {
                title: '{{ __('NIP') }}',
                data: 'employee.nip',
                className: "text-capitalize"
            },
            {
                title: '{{ __('Address') }}',
                data: 'employee.address',
                className: "text-capitalize"
            },
            {
                title: '{{ __('Phone') }}',
                data: 'employee.phone',
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
            var form = $("#user-form");
            saveForm(form, form.attr('action'), $('#modalForm'), 'POST', true);
        });

        function attactEdit(modal, response) {
            modal.find("input[name=id]").val(response.data.id);
            modal.find("input[name=name]").val(response.data?.employee.name);
            modal.find("input[name=username]").val(response.data?.username);
            modal.find("input[name=nip]").val(response.data?.employee.nip);
            modal.find("textarea[name=address]").val(response.data?.employee.address);
            modal.find("input[name=phone]").val(response.data?.employee.phone);
        }
    </script>
@endpush
