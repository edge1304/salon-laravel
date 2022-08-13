

@extends('layouts.admin')
@section('title')

    <title>Phiếu xuất bán | Chi tiết phiếu</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/css/formexport/add.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="row head-find" >
                <div class="col-6 col-sm-6 col-md-3 col-lg-3  col-xl-3 div-find-customer">
                    <label>Tên khách hàng</label>
                    <input class="form-control" id="input_name_customer" value="{{$data->customer['name']}}" oninput="find_customer(callback_find_customer)" placeholder="Nhập tên hoặc sđt khách hàng" type="text">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="list-ajax"></div>
                </div>
                <div class="col-6 col-sm-6 col-md-3 col-lg-3  col-xl-3">
                    <label>Số điện thoại</label>
                    <input class="form-control" id="input_phone_customer" value="{{$data->customer['phone']}}" placeholder="Số điện thoại" type="text" disabled>
                </div>
                <div class="col-12 col-sm-6 col-md-3 col-lg-3  col-xl-3">
                    <label>Địa chỉ</label>
                    <input class="form-control" id="input_adddress_customer" value="{{$data->customer['address']}}" placeholder="Địa chỉ" type="text" disabled>
                </div>
{{--                <div class="div-relative-btn">--}}
{{--                    <button onclick="showPopup('popupAddCustomer',true)" class="btn btn-primary"><i class="fas fa-user-plus"></i></button>--}}
{{--                </div>--}}
            </div>
            <div class="container-fluid">
                <div id="div-table-main">
                    <table id="table_product" class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="col-name-product">Tên sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>VAT</th>
                            <th>CK</th>
                            <th>Giảm giá</th>
                            <th>Nhân viên 1</th>
                            <th>Nhân viên 2</th>
{{--                            <th>xóa</th>--}}
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($data['details'] as $item)
                                <tr>
                                    <td>{{$item['product_name']}}</td>
                                    <td>{{number_format($item['price'])}}</td>
                                    <td>{{number_format($item['quantity'])}}</td>
                                    <td>{{number_format($item['vat'])}}</td>
                                    <td>{{number_format($item['ck'])}}</td>
                                    <td>{{number_format($item['discount'])}}</td>
                                    <td>{{$item['employee_name1']}}</td>
                                    <td>{{$item['employee_name2']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="div-info-payment">
                    <table class="table table-bordered">
                        <tr>
                            <td><div>Tổng tiền:</div></td>
                            <td>
                                <input type="text" disabled class="form-control integer" id="total_money" value="{{number_format($data['receive_money'])}}" oninput="changeMoney()" value="0">
                            </td>
                            <td><div>Khách thanh toán:</div></td>
                            <td>
                                <input type="text" disabled class="form-control integer" id="total_receive" value="{{number_format($data['total_money'])}}" oninput="changeMoney()" value="0">
                            </td>
                            <td><div>Đã trả lại:</div></td>
                            <td>
                                <input type="text" disabled class="form-control integer" id="total_return" oninput="changeMoney()" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td><div>Ghi chú</div></td>
                            <td>
                                <input id="note" type="text" class="form-control"  disabled value="{{$data['note']}}" placeholder="Nhập ghi chú">
                            </td>
                            <td><div>Hình thức thanh toán</div></td>
                            <td>
                                <input id="note" type="text" class="form-control" disabled  value="{{$data['fundbook_name']}}" placeholder="Nhập ghi chú">
                            </td>
                            <td></td>
{{--                            <td>--}}
{{--                                <button onclick="save_form()" class="btn btn-primary">Lưu phiếu</button>--}}
{{--                            </td>--}}
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('popup')

    <div class="modal" id="popupAddCustomer" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm mới khách hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="form-group">
                            <label for="name">Nhập tên khách hàng</label>
                            <input type="text" class="form-control" id="input_add_name_customer"  name="name" placeholder="Nhập tên khách hàng" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input name="phone" class="form-control" id="input_add_phone_customer" type="text" placeholder="nhập số điện thoại">
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input name="address" class="form-control" id="input_add_address_customer" type="text" placeholder="nhập địa chỉ">
                        </div>
                        <div class="form-group">
                            <label for="product_price">email</label>
                            <input name="email" type="email" id="input_add_email_customer" class="form-control" placeholder="Nhập địa chỉ email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="confirm_add_user()" data-dismiss="modal" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if(session()->has('error'))
        <script>alert('{{session()->get('error')}}')</script>
    @endif

@endsection
