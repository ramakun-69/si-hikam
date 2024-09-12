
function deleteData(url,type = "get",method = null,btn){
    btn.html(buildLoading())
    btn.addClass('disabled')
    $.ajax({
        type: type,
        url: url,
        data : method,
        dataType: "JSON",
        success: function (response) {
            if(response.status){
                if(_DATATABLE){
                    _DATATABLE.ajax.reload()
                }
                btn.removeClass('disabled');
                iziToast.success({
                    title: 'Success',
                    message: 'Success Menghapus data',
                    position: 'bottomCenter'
                });
            }
        }
    });
}
