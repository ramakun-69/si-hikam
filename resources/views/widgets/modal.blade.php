{{-- Modal Form --}}

<div id="modalForm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog {{ $type }}">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title">{{ $title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                {!! $form !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect"
                    data-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-primary" id="btn-submit" type="submit"> {{ __('Save') }} </button>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $('#modalForm').on('keydown', 'input', function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                return false;
            }
        });
        var _TITLE_PAGE = "{{ __('Add') . ' ' . $title }}";
        var _TITLE_PAGE_EDIT = "{{ __('Edit ') }}" + "{{ $title }}";

        $(document).on('hidden.bs.modal', '#modalForm', function() {
            resetModal();
        })
        $(document).on('hidden.bs.modal', '#modalSpp', function() {
            resetModal();
        })
        $(document).on('show.bs.modal', '#modalForm', function() {
            $(this).find(".modal-title").text(_TITLE_PAGE)
        })

        function resetModal() {
            console.log("reset modal");

            $("input").removeClass('is-invalid');
            $("textarea").removeClass('is-invalid');
            $("select").removeClass('is-invalid');
            $("small.text-danger").remove();
            $("select").prop('disabled', false);
            $(".select2-hidden-accessible").val(null).trigger('change');
            // $(".select2-hidden-accessible").prop('disabled', false);
            $("select[data-original-options]").each(function() {
                var originalOptions = $(this).data('original-options');
                if (originalOptions) {
                    var selectElement = this;
                    $(selectElement).empty();
                    $(selectElement).append('<option value="">{{ __('Please Select') }}</option>');
                    originalOptions.forEach(function(option) {
                        $(selectElement).append('<option value="' + option.value + '">' + option.text +
                            '</option>');
                    });
                }
            });
            $('#video').addClass('d-none');
            $('#image').addClass('d-none');
            clearInput($("#modalForm"))
        }



        $(document).on('click', '.edit', function(e) {
            var modal = $("#modalForm");
            var htmlThis = $(this);
            var htmlDef = htmlThis.html();
            htmlThis.addClass('disabled');
            htmlThis.toggleClass('d-flex align-items-center')
            htmlThis.html(buildLoading("15px", "15px"))
            e.preventDefault();
            $.ajax({
                type: "get",
                url: $(this).attr("href"),
                dataType: "JSON",
                success: function(response) {
                    if (response.status) {
                        attactEdit(modal, response, htmlThis)
                        $("#btn-submit").removeAttr("disabled")
                        $(".invalid").remove();
                        $("input,select").removeClass("is-invalid")
                        $("input,select").siblings("small.text-danger").remove();
                        htmlThis.removeClass("disabled");
                        htmlThis.toggleClass('d-flex align-items-center')
                        htmlThis.html(htmlDef)
                        modal.modal("show");
                        modal.find(".modal-title").text(_TITLE_PAGE_EDIT);
                    }
                }
            });
        });

        $(document).on('click', '.btn-show', function(e) {
            e.preventDefault();
            var modal = $("#modalShow");
            var htmlThis = $(this);
            var htmlDef = htmlThis.html();
            htmlThis.addClass('disabled');
            htmlThis.toggleClass('d-flex align-items-center')
            htmlThis.html(buildLoading("15px", "15px"))

            $.ajax({
                type: "get",
                url: $(this).attr("href"),
                dataType: "JSON",
                success: function(response) {
                    if (response.status) {
                        attactShow(modal, response)
                        htmlThis.removeClass("disabled");
                        htmlThis.toggleClass('d-flex align-items-center')
                        htmlThis.html(htmlDef)
                        modal.modal("show");
                    }
                }
            });
        });
    </script>
@endpush
