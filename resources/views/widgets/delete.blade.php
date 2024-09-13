@push('js')
<script>
$(document).on('click', '.trashed', function(e) {
    var btn = $(this);
    e.preventDefault();
    var type = $(this).data('type');
    Swal.fire({
        title: "{{ __('Are You Sure?') }}",
        text: "{{ __('Your Data Will Be Lost Forever') }}",
        icon: "warning",
        showClass: {
            popup: 'animate__animated animate__zoomIn animate__fast'
        },
        hideClass: {
          popup: 'animate__animated animate__zoomOut animate__fast'
        },
        showCancelButton: true,
        confirmButtonColor: "#0C768A",
        cancelButtonColor: "#da5643",
        confirmButtonText: "{{ __('Yes') }}",
        cancelButtonText: "{{ __('No') }}"
    }).then((result) => {
        if (result.isConfirmed) {
            var callback = null;
            if (type == 'redirect') {
                var redirect = btn.data('redirect')
                callback = function() {
                    window.location.href = redirect;
                }
            }
            deleteData(btn.attr('href'), 'post', {
                _method: 'delete'
            }, btn, callback);
            return;
        }
    });
});


function deleteData(url, method = "Get", data = null, btn, callback = null) {
    btn.html(buildLoading("15px","15px"))
    btn.addClass('disabled')
    $.ajax({
        type: method,
        url: url,
        data: data,
        dataType: "JSON",
        success: function(response) {
            if (response.status) {
                if (@json(isset($dt) ? $dt : false)) {
                    _DATATABLE.ajax.reload()
                }
                btn.removeClass('disabled');
                iziToast.success({
                    title: '{{ __("Success") }}',
                    message: response.data.message,
                    position: 'bottomCenter'
                });
                console.log(callback);
                if (callback) {
                    callback()
                }
            }
        }
    });
}
</script>
@endpush
