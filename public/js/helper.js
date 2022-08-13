$(function() {

    $('form').on("submit",()=>{
        const inputs = $('input.integer')
        for(let i =0;i<inputs.length;i++){
            $(inputs[i]).val(tryParseInt($(inputs[i]).val()))
        }
        const inputs_float = $('input.float')
        for(let i =0;i<inputs_float.length;i++){
            $(inputs_float[i]).val(tryParseFloat($(inputs_float[i]).val()))
        }
    })
    $("select, .select2").each(function() {
        $(this).select2({
            theme: "bootstrap4",
            width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
            placeholder: $(this).data("placeholder"),
            allowClear: Boolean($(this).data("allow-clear")),
            closeOnSelect: !$(this).attr("multiple"),
        })
    })

    //  chọn ảnh
    $(".div-select-image").on("click",(e)=>{
        let parent = e.target.parentElement
        if(parent.classList.contains("div-select-image")) parent = parent.parentElement

        const input = parent.querySelector('.input-select-image').click()
    })

    $(".input-select-image").on("input",(e)=>{
        const input = e.target
        const parent = e.target.parentElement
        const image = parent.querySelector('img')
        if (input.files && input.files[0]) {
            var reader = new FileReader()

            reader.onload = function (e) {
                image.setAttribute("src", e.target.result)
            }
            reader.readAsDataURL(input.files[0]) // convert to base64 string
        }
    })
    function initActiveMenu() {
        // === following js will activate the menu in left side bar based on url ====
        const origin = window.location.origin
        const pageUrl = window.location.href.replace(origin, '').split('?')[0].split('/')[1];

        $("#sidebar-menu a").each(function () {
            if (this.href.replace(origin, '').split('/')[1] === pageUrl) {

                $(this).addClass("active");
                $(this).parent().parent().parent().addClass("menu-open"); // add active to li of the current link

            }
        });
    }
    initActiveMenu()
})
var page_api = 1
const ACCESS_TOKEN = getCookie("token")
function getCookie(name) {
    var match = document.cookie.match(RegExp("(?:^|;\\s*)" + escapehtml(name) + "=([^;]*)"))
    return match ? match[1] : null
}


var stt = 1
const isDebug = true

function throwValue(val) {
    if (isDebug && val) {
        console.log(val)
    }
}

function throwError(e) {
    if (isDebug && e) {
        console.error(e)
    }
}

function logout() {
    setCookie("token", null)
    window.location = "/dang-nhap"
}

function getTime() {
    const date = new Date()
    return {
        startMonth: date.getFullYear() + "-" + addZero(date.getMonth() + 1) + "-01",
        current: date.getFullYear() + "-" + addZero(date.getMonth() + 1) + "-" + addZero(date.getDate()),
    }
}

function formatDate(time = new Date()) {
    time = new Date(time)
    return {
        fulldate: time.getFullYear() + "-" + addZero(time.getMonth() + 1) + "-" + addZero(time.getDate()),
        fulldatetime: time.getFullYear() + "-" + addZero(time.getMonth() + 1) + "-" + addZero(time.getDate()) + " " + addZero(time.getHours()) + ":" + addZero(time.getMinutes()) + ":" + addZero(time.getSeconds()),
    }
}

function setCookie(name, value, days = 30) {
    if (days) {
        var date = new Date()
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000)
        var expires = "; expires=" + date.toGMTString()
    } else var expires = ""
    document.cookie = name + "=" + value + expires + "; path=/"
}

function escapehtml(s) {
    return s.replace(/([.*+?\^$(){}|\[\]\/\\])/g, "\\$1")
}


function isLoading(status = true) {
    if (status) $("#loading_screen").show()
    else {
        $("#loading_screen").hide()
    }
}

const create_barcode = (text, tag, format = "code128", lineColor = "#24292e") => {
    JsBarcode(tag, text, {
        format: format,
        lineColor: lineColor,
        width: 1,
        height: 45,
        displayValue: true,
        fontSize: 12,
    })
}



const tryParseInt = function(str) {
    try {
        if (!isDefine(str)) return 0
        str = str.toString().split("")
        for (let i = 0; i < str.length; i++) {
            str[i] = str[i].replace(",", "").replace(/[a-z]/g, "")
        }
        var data = ""
        for (let i = 0; i < str.length; i++) {
            data += str[i].trim()
        }
        data = data.trim()
        return isNaN(parseInt(data)) ? 0 : parseInt(data)
    } catch (e) {
        console.log(e)
        return 0
    }
}

const tryParseFloat = function(str) {
    try {
        return isNaN(parseFloat(str)) ? 0 : parseFloat(str)
    } catch (e) {
        console.log(e)
        return 0
    }
}
const tryParseBoolean = (str) => {
    if (isDefine(str)) {
        switch (str.toString().toLowerCase().trim()) {
            case "true":
            case "yes":
            case "1":
                return true
            case "false":
            case "no":
            case "0":
                return false
            default:
                return Boolean(str)
        }
    } else {
        return false
    }
}
const isDefine = function(val) {
    try {
        if (!val) return false
        if (val == undefined) return false
        if (val == "") return false
        if (typeof val == "undefined") return false
        if (val == "undefined") return false
        return true
    } catch (err) {
        return false
    }
}

function stringToSlug(str) {
    // remove accents
    var from = "àáãảạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệđùúủũụưừứửữựòóỏõọôồốổỗộơờớởỡợìíỉĩịäëïîöüûñçýỳỹỵỷ",
        to = "aaaaaaaaaaaaaaaaaeeeeeeeeeeeduuuuuuuuuuuoooooooooooooooooiiiiiaeiiouuncyyyyy"
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(RegExp(from[i], "gi"), to[i])
    }

    str = str
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\-]/g, "-")
        .replace(/-+/g, "-")

    return str
}

function money(nStr) {
    if (typeof nStr == "undefined" || nStr == null) return 0
    nStr.toString()
    nStr += ""
    x = nStr.split(".")
    x1 = x[0]
    x2 = x.length > 1 ? "." + x[1] : ""
    var rgx = /(\d+)(\d{3})/
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, "$1" + "," + "$2")
    }
    return x1 + x2
}


//#region phân trang 2
// Phân trang
const CLASS_PAGE_ITEM = `page-item`
const CLASS_PAGE_ITEM_ACTIVE = `page-item active`
const CLASS_PAGE_LINK = `page-link`

//#endregion
function addZero(number, length = 2) {
    var my_string = "" + number
    while (my_string.length < length) {
        my_string = "0" + my_string
    }
    return my_string
}

function showPopup(popup, isEmpty = false, popupHide) {
    if (isEmpty) {
        $(`#${popup} input[type=text]`).val(null)
        $(`#${popup} input[type=text]`).attr("autocomplete", "off")
        $(`#${popup} input[type=file]`).val(null)
        $(`#${popup} .empty`).empty()

        $(`#${popup} .number`).val(0)
        $(`#${popup} img`).attr("src", IMAGE_NULL)
    }
    $(`#${popup}`).modal("show")
    if (typeof popupHide != "undefined") {
        hidePopup(popupHide)
    }
}

function hidePopup(popup, popupShow) {
    $(`#${popup}`).modal("hide")
    if (typeof popupShow != "undefined") {
        showPopup(popupHide)
    }
}

function success(text_tb) {
    Swal.fire("Thông Báo", text_tb, "success")
}

function warning(text_tb) {
    Swal.fire("Thông Báo", text_tb, "warning")
}

function error(text_tb) {
    Swal.fire("Thông Báo", text_tb, "error")
}

function info(text_tb) {
    Swal.fire("Thông Báo", text_tb, "info")
}

function inputNumber(input = event.target, typeNumber = "int") {
    if (typeof input == "undefined") input = $(event.path[0])
    if ($(input).val().length == 0) $(input).val(0)
    if (typeNumber == "int") $(input).val(money(tryParseInt($(input).val())))
    if (typeNumber == "float") {
        $(input).val(money(tryParseFloat($(input).val())))
    }
}

function isChecked(time) {
    if (time.hours == 0 && time.minutes == 0 && time.seconds == 0) return false
    return true
}

function achievement(in_morning, out_morning, in_afternoon, out_afternoon) {
    let number = 0
    if (isChecked(in_morning) && isChecked(out_morning)) {
        const totalMinutes = (out_morning.hours * 60 + out_morning.minutes - in_morning.hours * 60 + in_morning.minutes) / 60

        if (totalMinutes / 8 > 0.5) number = 0.5
        else number = totalMinutes / 8
    }
    if (isChecked(in_afternoon) && isChecked(out_afternoon)) {
        const totalMinutes = (in_afternoon.hours * 60 + in_afternoon.minutes - out_afternoon.hours * 60 + out_afternoon.minutes) / 60

        if (totalMinutes / 8 > 0.5) number += 0.5
        else number += totalMinutes / 8
    }
    return round2(number)
}

function dataTable(id, isButton = true) {
    if (typeof id == "undefined" || id == null) {
        id = "dataTable"
    }
    var buttons = ["copy", "csv", "excel", "pdf", "print"]
    if (!isButton) {
        buttons = []
    }
    $(`#${id} thead tr`)
        .clone(true)
        .addClass('filters')
        .appendTo(`#${id} thead`);
    $(`#${id}`).DataTable({
        dom: "Bfrtip",
        lengthChange: true,
        paging: true,
        orderable: true,
        lengthMenu: [
            [10, 30, 40, 50, -1],
            [10, 30, 40, 50, "Tất cả"],
        ],
        buttons: buttons,
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function() {
            var api = this.api();

            // For each column
            api
                .columns()
                .eq(0)
                .each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');

                    // On every keypress in this input
                    $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                        .off('keyup change')
                        .on('change', function(e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();

                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != '' ?
                                    regexr.replace('{search}', '(((' + this.value + ')))') :
                                    '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function(e) {
                            e.stopPropagation();

                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },

    })
}

function dataTable2(table, isButton = true, islength = true, isPaging = true) {
    if (typeof table == "undefined" || table == null) {
        table = $("#dataTable")
    }
    var buttons = ["copy", "csv", "excel", "pdf", "print"]
    if (!isButton) {
        buttons = []
    }
    // $(`${table} thead tr`)
    //     .clone(true)
    //     .addClass('filters')
    //     .appendTo(`${table} thead`);

    const tr_thead = $(table).find('thead tr')
    for (let i = 0; i < tr_thead.length; i++) {
        $(tr_thead[i]).clone(true).addClass('filters').appendTo(`thead`);
    }

    table.DataTable({
        dom: "Bfrtip",
        lengthChange: islength,
        paging: isPaging,
        orderable: true,
        lengthMenu: [
            [10, 30, 40, 50, -1],
            [10, 30, 40, 50, "Tất cả"],
        ],
        buttons: buttons,
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function() {
            console.log("???")
            var api = this.api();

            // For each column
            api
                .columns()
                .eq(0)
                .each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');

                    // On every keypress in this input
                    $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                        .off('keyup change')
                        .on('change', function(e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();

                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != '' ?
                                    regexr.replace('{search}', '(((' + this.value + ')))') :
                                    '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function(e) {
                            e.stopPropagation();

                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },

    })
}

function decimalAdjust(type, value, exp) {
    try {
        if (!isDefine(value)) return false
            // If the exp is undefined or zero...
        if (typeof exp === "undefined" || +exp === 0) {
            return Math[type](value)
        }
        value = +value
        exp = +exp
            // If the value is not a number or the exp is not an integer...
        if (isNaN(value) || !(typeof exp === "number" && exp % 1 === 0)) {
            return NaN
        }
        // Shift
        value = value.toString().split("e")
        value = Math[type](+(value[0] + "e" + (value[1] ? +value[1] - exp : -exp)))
            // Shift back
        value = value.toString().split("e")
        return +(value[0] + "e" + (value[1] ? +value[1] + exp : exp))
    } catch (err) {
        throwError(err)
        return false
    }
}

const round2 = (value) => decimalAdjust("round", value, -2)
const round = (value) => decimalAdjust("round", value, 0)
    // Decimal floor
const floor2 = (value) => decimalAdjust("floor", value, -2)
    // Decimal ceil
const ceil2 = (value) => decimalAdjust("ceil", value, -2)
const ceil = (value) => decimalAdjust("ceil", value, 0)

function dayOfWeek(val) {
    var currentDate = new Date(val)
    if (currentDate.getDay() == 0) {
        currentDate.setDate(currentDate.getDate() - 1)
    }
    const monday = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 1)).toUTCString()
    const tuesday = nextDay(monday)
    const wednesday = nextDay(tuesday)
    const thursday = nextDay(wednesday)
    const friday = nextDay(thursday)
    const saturday = nextDay(friday)
    const sunday = nextDay(saturday)

    return {
        monday: monday,
        tuesday: tuesday,
        wednesday: wednesday,
        thursday: thursday,
        friday: friday,
        saturday: saturday,
        sunday: sunday,
    }
}

function nextweek() {
    var today = new Date()
    var nextweek = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7)
    return nextweek
}

function nextDay(val) {
    var currentDate = new Date(val)
    return new Date(currentDate.setDate(currentDate.getDate() + 1)).toUTCString()
}

function sameDay(val1, val2) {
    val1 = new Date(val1)
    val2 = new Date(val2)

    if (val1.getDate() == val2.getDate() && val1.getMonth() == val2.getMonth() && val1.getFullYear() == val2.getFullYear()) {
        return true
    }
    return false
}

$(window).on("popstate", function(event) {
    window.location = window.location.search
    window.history.pushState({ id: 1 }, null, "")
})

function changeURL(urlPath) {
    window.history.pushState({ id: 1 }, null, urlPath)
}

$("#keyFind").on("keypress", (event) => {
    if (event.which == "13") {
        getData(false)
    }
})

function downloadExcelLocal(data, fileName = "download") {
    var opts = [
        { sheetid: "One", header: true },
        { sheetid: "Two", header: false },
    ]
    alasql(`SELECT INTO XLSX("${fileName}.xlsx",?) FROM ?`, [opts, [data]])
}

function errAjax(data) {
    isLoading(false)
    if (data.status == 503 || data.status == 502) info("Server bị ngắt kết nối , hãy kiểm tra lại mạng của bạn")
    if (data != null && data.status != 503 && data.status != 502) info(data.responseText)
}

function callAPI(method = "GET", url, data, successAjax, errorAjax = errAjax, isFile = false, isLoad = true) {
    var ObjectAjax = {
        type: method,
        url: url,
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: data,
        cache: false,
        success: function(data) {
            isLoading(false)
            successAjax(data)
        },
        error: function(data) {
            errorAjax(data)
        },
    }
    if (isFile) {
        ObjectAjax = {
            ...ObjectAjax,
            contentType: false,
            processData: false,
        }
    }

    isLoading(isLoad)
    $.ajax(ObjectAjax)
}

function totalMoney(price = 0, vat = 0, ck = 0, discount = 0, number = 1) {
    return (tryParseInt(price) + (tryParseInt(price) / 100) * tryParseInt(vat) - (tryParseInt(price) / 100) * tryParseInt(ck) - tryParseInt(discount)) * tryParseInt(number)
}

function newPage(link) {
    const a = document.createElement("a")
    a.setAttribute("href", link)
    a.setAttribute("target", `_blank`)
    a.click()
}
var mangso = ["không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín"]

function dochangchuc(so, daydu) {
    var chuoi = ""
    chuc = Math.floor(so / 10)
    donvi = so % 10
    if (chuc > 1) {
        chuoi = " " + mangso[chuc] + " mươi"
        if (donvi == 1) {
            chuoi += " mốt"
        }
    } else if (chuc == 1) {
        chuoi = " mười"
        if (donvi == 1) {
            chuoi += " một"
        }
    } else if (daydu && donvi > 0) {
        chuoi = " lẻ"
    }
    if (donvi == 5 && chuc > 1) {
        chuoi += " lăm"
    } else if (donvi > 1 || (donvi == 1 && chuc == 0)) {
        chuoi += " " + mangso[donvi]
    }
    return chuoi
}

function docblock(so, daydu) {
    var chuoi = ""
    tram = Math.floor(so / 100)
    so = so % 100
    if (daydu || tram > 0) {
        chuoi = " " + mangso[tram] + " trăm"
        chuoi += dochangchuc(so, true)
    } else {
        chuoi = dochangchuc(so, false)
    }
    return chuoi
}

function dochangtrieu(so, daydu) {
    var chuoi = ""
    trieu = Math.floor(so / 1000000)
    so = so % 1000000
    if (trieu > 0) {
        chuoi = docblock(trieu, daydu) + " triệu"
        daydu = true
    }
    nghin = Math.floor(so / 1000)
    so = so % 1000
    if (nghin > 0) {
        chuoi += docblock(nghin, daydu) + " nghìn"
        daydu = true
    }
    if (so > 0) {
        chuoi += docblock(so, daydu)
    }
    return chuoi
}

function tranfer_number_to_text(so) {
    if (so == 0) return mangso[0]
    var chuoi = "",
        hauto = ""
    do {
        ty = so % 1000000000
        so = Math.floor(so / 1000000000)
        if (so > 0) {
            chuoi = dochangtrieu(ty, true) + hauto + chuoi
        } else {
            chuoi = dochangtrieu(ty, false) + hauto + chuoi
        }
        hauto = " tỷ"
    } while (so > 0)
    chuoi = chuoi.trim()
    return chuoi.charAt(0).toUpperCase() + chuoi.slice(1)
}

function find_customer(callback, isMore = false){
    const div_root = $(event.target).parent()
    const input = $(div_root).find('input')
    const loading = $(div_root).find('.spinner-border')
    if(!isMore) page_api = 1
    $(input).attr("name",null)

    const div_show = $(div_root).find('div:last-child')
    const key = $(input).val().trim()
    if(key.length == 0){
        $(div_show).empty()
        return
    }
    $(loading).show()
    callAPI('GET',`${API_CUSTOMER}/find-other`,{
        limit:10,
        page:page_api,
        search:key
    }, data =>{
        $(loading).hide()
        callback(data , isMore)
    })
}
function find_product(callback, isMore = false){
    const element = $(event.target)
    const div_root = $(element).parent()
    const input = $(div_root).find('input')
    const loading = $(div_root).find('.spinner-border')
    const div_show = $(div_root).find('div:last-child')
    if(!isMore) page_api = 1
    $(input).attr("name",null)
    const key = $(input).val().trim()
    if(key.length == 0){
        $(div_show).empty()
        return
    }
    $(loading).show()
    callAPI('GET',`${API_PRODUCT}/find-other`,{
        limit:10,
        page:page_api,
        search:key
    }, data =>{
        $(loading).hide()
        callback(data , isMore, element)
    })
}
function find_employee(callback, isMore = false){
    const element = $(event.target)
    const div_root = $(element).parent()
    const input = $(div_root).find('input')
    const loading = $(div_root).find('.spinner-border')
    const div_show = $(div_root).find('div:last-child')
    if(!isMore) page_api = 1
    $(input).attr("name",null)
    const key = $(input).val().trim()
    if(key.length == 0){
        $(div_show).empty()
        return
    }
    $(loading).show()
    callAPI('GET',`${API_EMPLOYEE}/find-other`,{
        limit:10,
        page:page_api,
        search:key
    }, data =>{
        $(loading).hide()
        callback(data , isMore, element)
    })
}
