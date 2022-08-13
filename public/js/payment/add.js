var arrCustomer = []
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
    $("#customer_id").val(arrCustomer[index].id)
    $("#input_phone_customer").val(arrCustomer[index].phone)
    $("#input_adddress_customer").val(arrCustomer[index].address)

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
        $("#customer_id").val(data.data.id)
        $("#input_phone_customer").val(data.data.phone)
        $("#input_adddress_customer").val(data.data.address)
    })
}
