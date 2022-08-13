

@extends('layouts.admin')
@section('title')
    <title>Quản lý khách hàng | Chỉnh sửa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')

@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <form method="post" action="{{route("admin.customer.update",['id'=> $customer->id])}}" >
                @csrf
                <div class="form-group">
                    <label for="category_name">Nhập tên nhân viên</label>
                    <input type="text" class="form-control" value="{{$customer->name}}"  name="name" placeholder="Nhập tên khách hàng" required>
                </div>
                <div class="form-group">
                    <label for="product_price">Số điện thoại</label>
                    <input name="phone" class="form-control" value="{{$customer->phone}}" type="text" placeholder="nhập số điện thoại">
                </div>
                <div class="form-group">
                    <label for="product_price">Địa chỉ</label>
                    <input name="address" class="form-control" value="{{$customer->address}}" type="text" placeholder="nhập địa chỉ">
                </div>
                <div class="form-group">
                    <label for="product_price">email</label>
                    <input name="email" type="email" class="form-control" value="{{$customer->email}}" placeholder="Nhập địa chỉ email">
                </div>

                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>

    </div>
@endsection


@section('script')
    @if(session()->has('error'))
        <script>alert('{{session()->get('error')}}')</script>
    @endif
@endsection
