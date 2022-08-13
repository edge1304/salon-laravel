

@extends('layouts.admin')
@section('title')
    <title>Phiếu chi | Thêm mới</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/css/payment/add.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <form method="post" action="{{route("admin.payment.insert")}}" >
                @csrf
                <div class="form-group">
                    <div class="row head-find" >
                        <div class="col-6 col-sm-6 col-md-3 col-lg-3  col-xl-3 div-find-customer">
                            <label>Tên khách hàng</label>
                            <input class="form-control" required id="input_name_customer" name="name_customer" oninput="find_customer(callback_find_customer)" placeholder="Nhập tên hoặc sđt khách hàng" type="text">

                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="list-ajax"></div>
                        </div>
                        <input id="customer_id" required name="customer_id" style="display: none">
                        <div class="col-6 col-sm-6 col-md-3 col-lg-3  col-xl-3">
                            <label>Số điện thoại</label>
                            <input class="form-control" id="input_phone_customer" placeholder="Số điện thoại" type="text" disabled>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-3  col-xl-3">
                            <label>Địa chỉ</label>
                            <input class="form-control" id="input_adddress_customer" placeholder="Địa chỉ" type="text" disabled>
                        </div>
                        <div class="div-relative-btn">
                            <button type="button" onclick="showPopup('popupAddCustomer',true)" class="btn btn-primary"><i class="fas fa-user-plus"></i></button>
                        </div>
                    </div>
                    <div>
                        <label>Nội dụng chi</label>
                        <select required name="accounting_entry_id">
                            <option value="">________________</option>
                            {!! $htmlAccounting !!}
                        </select>
                    </div>
                    <div>
                        <label>Tổng tiền</label>
                        <input required class="form-control integer" oninput="inputNumber()" name="money" value="0" placeholder="Nhập tiền" type="text">
                    </div>

                    <div>
                        <label>Hình thức thanh toán</label>
                        <select required name="fundbook_id">
                            {!! $htmlFundbook !!}
                        </select>
                    </div>
                    <div>
                        <label>Ghi chú</label>
                        <input class="form-control"  name="note"  placeholder="Nhập ghi chú" type="text">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
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
    <script src="/js/payment/add.js"></script>
@endsection
