

@extends('layouts.admin')
@section('title')
    <title>Quản lý sản phẩm</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/css/product/index.css')}}" >
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
                    <input onkeypress="searchData()" id="keyFind" value="{{$key}}" class="form-control" placeholder="Nhập tên sản phẩm">
                </div>
                <div class="col col-md-2 div-relative-btn">
                    <a href="{{route('admin.product.add')}}" class="btn btn-primary">Thêm mới</a>
                </div>
            </div>
            <div class="container-fluid">
                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Danh mục</th>
                            <th>Thưởng</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>

                        @for ($i  = 0 ; $i < count($products); $i++)
                            <tr>
                                <td>{{$i+1+(($page-1)*$limit)}}</td>
                                <td>{{$products[$i]->product_name}}</td>
                                <td>{{number_format($products[$i]->product_price)}}</td>
                                <td>{{$products[$i]->category_name}}</td>
                                <td>{{number_format($products[$i]->product_part)}}</td>
                                <td><img src=""></td>
                                <td>
                                    <a href="{{route('admin.product.edit', ['id' => $products[$i]->id])}}"><i title="chỉnh sửa" class="fas fa-edit text-primary"></i></a>
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
                <div>
                    {{$products->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('popup')


@endsection

@section('script')
    @if(session()->has('success'))
        <script>alert('{{session()->get('success')}}')</script>
    @endif
    <script src="/js/product/index.js"></script>
@endsection
