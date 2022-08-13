var arrCustomer = []
var arrProduct = []
var arrEmployee = []
add_row()
function add_row(){
    $("#table_product tbody").append(`
        <tr>
            <td>
                <div class="find-product">
                    <input class="form-control name-product" oninput="find_product(callback_find_product)"  placeholder="Nhập tên sản phẩm" type="text">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="list-ajax"></div>
                </div>
            </td>
            <td>
                <input type="text" class="form-control integer price" oninput="changeMoney()" value="0">
            </td>
            <td>
                <input type="text" class="form-control integer quantity" oninput="changeMoney()" value="0">
            </td>
            <td>
                <input type="text" class="form-control integer vat" oninput="changeMoney()" value="0">
            </td>
            <td>
                <input type="text" class="form-control integer ck" oninput="changeMoney()" value="0">
            </td>
            <td>
                <input type="text" class="form-control integer discount" oninput="changeMoney()" value="0">
            </td>
            <td>
                <div class="find-employee">
                    <input class="form-control name-employee" oninput="find_employee(callback_find_employee)" placeholder="Nhập tên nhân viên" type="text">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="list-ajax"></div>
                </div>
            </td>
            <td>
                <div class="find-employee">
                    <input class="form-control name-employee" oninput="find_employee(callback_find_employee)" placeholder="Nhập tên nhân viên" type="text">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="list-ajax"></div>
                </div>
            </td>
            <td>
                <i onclick="removeRow()" class="fas fa-trash text-danger"></i>
            </td>
        </tr>
    `)
}

function  callback_find_customer(data , isMore){
    const div_list = document.querySelector('.div-find-customer .list-ajax')
    if(!isMore){
        arrCustomer = []
        div_list.innerHTML = null
    }
    data.map( customer =>{
        arrCustomer.push(customer)
        div_list.innerHTML += `<li><a onclick="selectCustomer(${arrCustomer.length-1})" href="javascript:void(0)">${customer.name}</a></li>`
    })
}

function  selectCustomer(index){

    $(event.target).parent().parent().empty()
    $("#input_name_customer").val(arrCustomer[index].name)
    $("#input_name_customer").attr("name",arrCustomer[index].id)
    $("#input_phone_customer").val(arrCustomer[index].phone)
    $("#input_adddress_customer").val(arrCustomer[index].address)



}


function  callback_find_product(data , isMore , element){

    const div_list = $(element).parent().find('div.list-ajax')
    if(!isMore){
        arrProduct = []
        div_list.empty()
    }

    data.map( product =>{
        arrProduct.push(product)
        div_list.append(`<li><a onclick="selectProduct(${arrProduct.length-1})" href="javascript:void(0)">${product.product_name}</a></li>`)
    })
}

function selectProduct(index){
    const div_list = $(event.target).parent().parent().empty()
    const tr = $(div_list).parent().parent().parent()

    $(tr).find('.name-product').val(arrProduct[index].product_name)
    $(tr).find('.name-product').attr("name",arrProduct[index].id)
    $(tr).find('.price').val(money(arrProduct[index].product_price))
    $(tr).find('.vat').val(0)
    $(tr).find('.quantity').val(1)
    $(tr).find('.ck').val(0)
    $(tr).find('.discount').val(0)

    if( $(tr).index() == $("#table_product tbody").find('tr').length-1 ){
        add_row()
    }
    changeMoney()
}


function removeRow() {
    const tr = $(event.target).closest('tr')
    const tbody = $(event.target).closest('tbody')

    if( $(tr).index() != $(tbody).find('tr').length-1 ){
        $(tr).remove()
        changeMoney()
    }
}
function changeMoney(){
    const trs = $("#table_product tbody tr")

    if(event.type == 'input' && $(event.target).hasClass('integer')){
        $(event.target).val(money(tryParseInt($(event.target).val())))
    }
    let total = 0
    for(let i =0;i<trs.length;i++){
        const name_product = $(trs[i]).find('.name-product')
        if($(name_product).attr("name") && tryParseInt($(name_product).attr("name")) > 0){

            const price = $(trs[i]).find('input.price').val()
            const quantity = $(trs[i]).find('input.quantity').val()
            const vat = $(trs[i]).find('input.vat').val()
            const ck = $(trs[i]).find('input.ck').val()
            const discount = $(trs[i]).find('input.discount').val()

            total += totalMoney(price, vat, ck ,discount, quantity)
        }
    }

    $("#total_money").val(money(total))
    const total_receive = tryParseInt($("#total_receive").val())
    const total_return = (total_receive - total) > 0 ?(total_receive - total):0
    $("#total_return").val(money(total_return))

}
function  callback_find_employee(data , isMore , element){

    const div_list = $(element).parent().find('div.list-ajax')
    if(!isMore){
        arrEmployee = []
        div_list.empty()
    }

    data.map( employee =>{
        arrEmployee.push(employee)
        div_list.append(`<li><a onclick="selectEmployee(${arrEmployee.length-1})" href="javascript:void(0)">${employee.name} - ${employee.phone}</a></li>`)
    })
}

function selectEmployee(index){
    const div_list = $(event.target).parent().parent().empty()
    const td = $(div_list).parent().parent()

    $(td).find('input').val(arrEmployee[index].name)
    $(td).find('input').attr("name",arrEmployee[index].id)
}

function  save_form(){

    const customer_id = $("#input_name_customer").attr("name")
    if(!customer_id){
        info("Khách hàng không được để trống!")
        return;
    }

    const trs = $("#table_product tbody tr")
    const array_product = []
    for(let i =0;i<trs.length;i++){
        const product_id = $(trs[i]).find('input.name-product').attr("name")
        if(product_id){
            const price = $(trs[i]).find('input.price').val()
            const quantity = $(trs[i]).find('input.quantity').val()
            const vat = $(trs[i]).find('input.vat').val()
            const ck = $(trs[i]).find('input.ck').val()
            const discount = $(trs[i]).find('input.discount').val()
            const part = $(trs[i]).find('input.part').val()
            var id_employee = $($($(trs[i]).find('input.name-employee'))[0]).attr("name")
            var id_employee2 = $($($(trs[i]).find('input.name-employee'))[1]).attr("name")
            if(id_employee) id_employee = tryParseInt(id_employee)
            if(id_employee2) id_employee2 = tryParseInt(id_employee2)

            array_product.push({
                product_id:tryParseInt(product_id),
                price:tryParseInt(price),
                quantity:tryParseInt(quantity),
                vat:tryParseInt(vat),
                ck:tryParseInt(ck),
                discount:tryParseInt(discount),
                employee_id:id_employee,
                employee_id2:id_employee2
            })

        }
    }
    if(array_product.length == 0){
        info("Hãy nhập ít nhất 1 sản phẩm")
        return
    }
    const note = $("#note").val()
    const fundbook_id = $("#selectFundnook option:selected").val()
    const total_receive = tryParseInt($("#total_receive").val())
    const total_return = tryParseInt($("#total_return").val())
    const paid = total_receive - total_return

    if(fundbook_id == "") {
        info("Bạn chưa thiết lập hình thức thanh toán")
        return;
    }
    const info_form = {
        note:note,
        fundbook_id: tryParseInt(fundbook_id),
        paid:paid,
        array_product:array_product,
        customer_id:customer_id
    }
    callAPI('POST',`${API_EXPORT}/tao-moi`,{
        data: JSON.stringify(info_form)
    }, data =>{
        success("Thành công")
        newPage(`/xuat-hang/in-phieu/${data.data.id}`)
        location.reload()
    })

}

function confirm_add_user(){
    const name = $("#input_add_name_customer").val().trim()
    const phone = $("#input_add_phone_customer").val().trim()
    const address = $("#input_add_address_customer").val().trim()
    const email = $("#input_add_email_customer").val().trim()

    if(name.length == 0){
        info("Tên khách hàng không được để trống")
        return
    }

    callAPI('post',`${API_CUSTOMER}/tao-moi-api`,{
        name:name,
        phone:phone,
        address:address,
        email:email
    }, data =>{
        success("Thêm khách hàng thành công")
        $("#input_name_customer").val(data.data.name)
        $("#input_name_customer").attr("name",data.data.id)
        $("#input_phone_customer").val(data.data.phone)
        $("#input_adddress_customer").val(data.data.address)
    })
}
