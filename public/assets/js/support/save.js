// submit data
var _LOADING = `<div class="w-100 d-flex align-items-center">
            <div class="m-auto d-flex align-items-center">
                ${buildLoadingBorder(
                    "20px",
                    "20px"
                )} <span class="ms-2">Tunggu sebentar ...</span>
            </div>
        </div>`;

function saveForm(
    form,
    url,
    modal,
    method = "post",
    withFile = false,
    button = null,
    callback = null
) {
    new Promise((resolve, reject) => {
        var btn = modal.find("#btn-submit").length
            ? modal.find("#btn-submit")
            : button;
        var btnOri = btn.html();
        var result = false;
        var validate = false;
        var data = null;
        // validate = validateInput(form,igoneinput);
        resetErrorValidate(form);
        if (withFile) {
            data = new FormData(form[0]);
        } else {
            data = form.serialize() + "&_method=" + method;
        }
        if (true) {
            btn.attr("disabled", "disabled");
            btn.html(_LOADING);
            var option = {
                type: method,
                url: url,
                data: data,
                dataType: "JSON",
                success: function (response) {
                    if (response.status == false) {
                        console.log(response);
                        iziToast.warning({
                            title: translations.failed,
                            message: response.data.message,
                            position: "bottomCenter",
                        });
                    } else {
                        modal.modal("hide");
                        if (_DATATABLE) {
                            _DATATABLE.ajax.reload();
                        }
                        result = true;
                        iziToast.success({
                            title: translations.success,
                            message: response.data.message,
                            position: "bottomCenter",
                        });
                    }
                    resetBtnSubmit(btn, btnOri);
                    clearInput(form);
                    resolve(response);
                    form.find("input[type=file]").val(null);
                },
                statusCode: {
                    422: function (response) {
                        var data = jsonToArray(response.responseJSON.data);
                        var target;
                        data.forEach(function (e) {
                            target = $("#" + e.key);
                            console.log(e.key);
                            target.addClass("is-invalid");
                            if (target.closest(".input-group").length > 0) {
                                target
                                    .closest(".input-group")
                                    .siblings("small.text-danger")
                                    .remove();
                                target
                                    .closest(".input-group")
                                    .siblings("small.text-danger")
                                    .after(
                                        `<small class="text-danger">${e.value}</small>`
                                    );
                            } else {
                                target.siblings("small.text-danger").remove();
                                target.after(
                                    `<small class="text-danger">${e.value}</small>`
                                );
                            }
                        });
                        iziToast.error({
                            title: translations.failed,
                            message: response.responseJSON.message,
                            position: "bottomCenter",
                        });
                        resetBtnSubmit(btn, btnOri);
                    },
                    500: function (response) {
                        if (response && response.responseJSON.data.error) {
                            iziToast.error({
                                title: translations.failed,
                                message: response.responseJSON.data.error,
                                position: "bottomCenter",
                            });
                        }
                        resetBtnSubmit(btn, btnOri);
                        reject(response);
                    },
                    400: function (response) {
                        if (response && response.responseJSON.data.error) {
                            iziToast.error({
                                title: translations.failed,
                                message: response.responseJSON.data.error,
                                position: "bottomCenter",
                            });
                        }
                        resetBtnSubmit(btn, btnOri);
                        reject(response);
                    },
                },
            };

            if (withFile) {
                option.processData = false;
                option.contentType = false;
            }
            $.ajax(option).done(function () {
                resetBtnSubmit(btn, btnOri);
                clearInput(form);
            });
        } else {
            console.error("validate false");
        }
        return result;
    });
}

function saveFormNotForModal(
    form,
    url,
    btn,
    method = "post",
    withFile = false,
    callback = null
) {
    return new Promise((resolve, reject) => {
        var btnOri = btn.html();
        resetErrorValidate(form);
        form.find(".ckeditor").each(function () {
            var editorInstance = this.editorInstance; // Akses instance editor dari elemen
            if (editorInstance) {
                $(this).val(editorInstance.getData());
            }
        });
        console.log(form[0]);

        if (withFile) {
            data = new FormData(form[0]);
            data.append("_method", method);
        } else {
            data = form.serialize() + "&_method=" + method;
        }
        btn.attr("disabled", "disabled");
        btn.html(_LOADING);

        var option = {
            type: "POST",
            url: url,
            data: data,
            dataType: "JSON",
            success: function (response) {
                resetBtnSubmit(btn, btnOri);
                if (response.status === false) {
                    iziToast.warning({
                        title: translations.failed,
                        message: response.data.message,
                        position: "bottomCenter",
                    });
                } else {
                    iziToast.success({
                        title: translations.success,
                        message: response.data.message,
                        position: "bottomCenter",
                    });
                }
                resolve(response);
                form.find("input[type=file]").val(null);
            },
            statusCode: {
                422: function (response) {
                    iziToast.error({
                        title: translations.failed,
                        message: response.responseJSON.message,
                        position: "bottomCenter",
                    });
                    var data = jsonToArray(response.responseJSON.data);
                    data.forEach(function (e) {
                        var target = $("#" + e.key);
                        target.addClass("is-invalid");
                        if (target.closest(".input-group").length > 0) {
                            target
                                .closest(".input-group")
                                .siblings("small.text-danger")
                                .remove();
                            target
                                .closest(".input-group")
                                .siblings("small.text-danger")
                                .after(
                                    `<small class="text-danger">${e.value}</small>`
                                );
                        } else {
                            target.siblings("small.text-danger").remove();
                            target.after(
                                `<small class="text-danger">${e.value}</small>`
                            );
                        }
                    });
                    resetBtnSubmit(btn, btnOri);
                    reject(response);
                },
                500: function (response) {
                    console.log(response);
                    if (response && response.responseJSON.data.error) {
                        iziToast.error({
                            title: translations.failed,
                            message: response.responseJSON.data.error,
                            position: "bottomCenter",
                        });
                    }
                    resetBtnSubmit(btn, btnOri);
                    reject(response.responseJSON.data.error);
                },
            },
        };

        if (withFile) {
            option.processData = false;
            option.contentType = false;
        }

        $.ajax(option);
    });
}
function ajax(url, btn, method = "post") {
    return new Promise((resolve, reject) => {
        var btnOri = btn.html();

        btn.attr("disabled", "disabled");
        btn.html(_LOADING);

        var option = {
            type: method,
            url: url,
            dataType: "JSON",
            success: function (response) {
                resetBtnSubmit(btn, btnOri);
                if (response.status === false) {
                    iziToast.warning({
                        title: translations.failed,
                        message: response.data.message,
                        position: "bottomCenter",
                    });
                } else {
                    iziToast.success({
                        title: translations.success,
                        message: response.data.message,
                        position: "bottomCenter",
                    });
                }
                resolve(response);
            },
            statusCode: {
                500: function (response) {
                    console.log(response);
                    if (response && response.responseJSON.data.error) {
                        iziToast.error({
                            title: translations.failed,
                            message: response.responseJSON.data.error,
                            position: "bottomCenter",
                        });
                    }
                    resetBtnSubmit(btn, btnOri);
                    reject(error);
                },
            },
        };

        $.ajax(option);
    });
}
function checkInputIgnore(inputName = [], name = "") {
    var result = false;
    inputName.forEach(function (item, index) {
        if (item == name) {
            result = true;
        }
    });
    return result;
}
function resetBtnSubmit(btn, btnOri) {
    btn.removeAttr("disabled");
    btn.empty();
    btn.html(btnOri);
}
function resetErrorValidate(form) {
    console.log(form.find("textarea")); // Ini akan menampilkan semua elemen <textarea> dalam form di console.
    form.find("select, input, textarea").removeClass("is-invalid");
    form.find("small.text-danger").remove();
}

function clearInput(form) {
    form.find("select").prop("selectedIndex", 0);
    form.find(
        "input[type=hidden],input[type=text],input[type=password],input[type=email],input[type=file],input[type=number],textarea"
    ).val("");
    form.find("input[type=file]").val(null);
    form.find("input[type=checkbox], input[type=radio]").prop("checked", false);
}
