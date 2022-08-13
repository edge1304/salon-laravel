

@extends('layouts.admin')
@section('title')
    <title>Phiếu Chi</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/css/formexport/index.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="row head-find" >
                <div class="col col-md-2">
                    <lable>Hiển thị</lable>
                    <select onchange="searchData()" id="selectLimit" class="form-control">
                        <?php
                        $array_limit = [10,20,50,100];

                        foreach($array_limit as $item){
                        $isSelect = "";
                        if($item == $limit) $isSelect = "selected"; ?>
                        <option {{$isSelect}} value="{{$item}}">{{$item}}</option>
                        <?php }?>
                    </select>
                </div>
                <div class="col col-md-3">
                    <lable>Tìm kiếm</lable>
                    <input onkeypress="searchData()" id="keyFind" value="{{$key}}" class="form-control" placeholder="Nhập mã phiếu hoặc tên khách">
                </div>
                <div class="col col-md-2">
                    <lable>Từ ngày</lable>
                    <input onchange="searchData()" type="date" id="fromdate" value="{{$fromdate}}" class="form-control" placeholder="Nhập mã phiếu hoặc tên khách">
                </div>
                <div class="col col-md-2">
                    <lable>Đến ngày</lable>
                    <input onchange="searchData()" type="date" id="todate" value="{{$todate}}" class="form-control" placeholder="Nhập mã phiếu hoặc tên khách">
                </div>
                <div class="col col-md-2 div-relative-btn">
                    <a href="{{route('admin.payment.add')}}" class="btn btn-primary">Thêm mới</a>
                </div>


            </div>
            <div class="container-fluid">
                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Mã phiếu</th>
                            <th>Ngày tạo</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Hình thức thanh toán</th>
                            <th>Nội dung</th>
                            <th>Hình động</th>
                        </tr>
                        </thead>
                        <tbody>

                            @for ($i  = 0 ; $i < count($data); $i++)
                                <tr>
                                    <td>{{$i+1+(($page-1)*$limit)}}</td>
                                    <td>{{$data[$i]['id']}}</td>
                                    <td>{{date_format($data[$i]['created_at'],"Y/m/d" )}}</td>
                                    <td>{{$data[$i]['name']}} - {{$data[$i]['phone']}}</td>

                                    <td>{{number_format($data[$i]['money'])}}</td>
                                    <td></td>
                                    <td></td>
                                    <td>

                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <div>
                    {{$data->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('popup')

    <div class="modal" id="popupDelete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa phiếu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn xóa phiếu xuất này</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if(session()->has('success'))
        <script>alert('{{session()->get('success')}}')</script>
    @endif
    <script src="/js/payment/index.js"></script>
@endsection
