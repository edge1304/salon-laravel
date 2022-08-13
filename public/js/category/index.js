function searchData(){
    const limit = tryParseInt($("#selectLimit option:selected").val())
    const key = $("#keyFind").val().trim()
    const page = 1
    var search = `?limit=${limit}&&page=${page}`
    if(key && key.length > 0){
        search += `&&ten-danh-muc=${key}`
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
