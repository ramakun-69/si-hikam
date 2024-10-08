<form enctype="multipart/form-data" action="{{ route('user.store') }}" method="POST" id="user-form">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input type="hidden" name="id">
                <input type="text" class="form-control" name="name" id="name" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nip">{{ __('NIP') }}</label>
                <input type="number" class="form-control angka" name="nip" min="0" id="nip" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="username">{{ __('Username') }}</label>
                <input type="text" class="form-control" name="username" id="username" autocomplete="off" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">{{ __('Phone') }}</label>
                <input type="text" class="form-control" name="phone" id="phone" autocomplete="off">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="adddress">{{ __('Address') }}</label>
                <textarea name="address" id="address" cols="30" class="form-control" autocomplete="off" rows="10"></textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="photo">{{ __('Photo') }}:</label>
                <input type="file" class="form-control" name="photo" id="photo">
            </div>
        </div>
        <div class="col-md-12">
            <small class="text-danger">{{ __('*Note: User password will be generated by default') }} <b>sihikam123#</b></small>
        </div>
    </div>
</form>

@push('js')
    <script>
        $("#nip").on('input', function(e) {
            var value = $(this).val();
            $("#username").val(value)
        });

        
    </script>
@endpush
