<form enctype="multipart/form-data" action="{{ route('type-of-leave.store') }}" method="POST" id="type-of-leave-form">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="name">{{ __("Laeve Name") }}</label>
                <input type="hidden" name="id">
                <input type="text" class="form-control" name="name" id="name" placeholder="{{ __("Example :") }} {{ __("Sick") }}" autocomplete="off">
            </div>
        </div>
    </div>
</form>