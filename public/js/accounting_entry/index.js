function searchData(){
    const limit = tryParseInt($("#selectLimit option:selected").val())
    const key = $("#keyFind").val().trim()
    const page = 1
    var search = `?limit=${limit}&page=${page}`
    if(key && key.length > 0){
        search += `&search=${key}`
    }
    const accounting_entry_type = $("#accounting_entry_type option:selected").val()
    if(accounting_entry_type && accounting_entry_type.length > 0) search += `&accounting_entry_type=${accounting_entry_type}`
    if(event.type == "keypress"){
        if(event.which == 13){
            window.location = search
        }
    }
    else{
        window.location = search
    }
}
