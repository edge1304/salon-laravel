function searchData(){

    const limit = tryParseInt($("#selectLimit option:selected").val())
    const key = $("#keyFind").val().trim()
    const page = 1
    const fromdate = $("#fromdate").val()
    const todate = $('#todate').val()
    var search = `?limit=${limit}&page=${page}&fromdate=${fromdate}&todate=${todate}`

    if(key && key.length > 0){
        search += `&&search=${key}`
    }

    if(event.type == "keypress"){
        if(event.which == 13){
            window.location = search
        }
    }
    else{
        window.location = search
    }
}
function showPopupDelete(id){
    $("#popupDelete .modal-footer button:first-child").attr(`onclick`,`confirmDelete(${id})`)
    showPopup('popupDelete')
}
function  confirmDelete(id){
    callAPI('delete',API_EXPORT,{
        id:id
    },data =>{
        success("Xóa thành công");
        const trs = $(".container-fluid table tbody tr");
        for(let i =0;i<trs.length;i++){
            const td = $(trs[i]).find('td:nth-child(2)');
            if(tryParseInt($(td).html()) == id){
                $(trs[i]).remove();
                break
            }
        }
    })
}
