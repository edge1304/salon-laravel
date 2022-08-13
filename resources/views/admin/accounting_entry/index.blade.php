

@extends('layouts.admin')
@section('title')
    <title>Bút toán thu chi</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/css/category/index.css')}}">
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
                    <lable>Loại</lable>
                    <select id="accounting_entry_type" onchange="searchData()">
                       {!! $html_type !!}
                    </select>
                </div>
                <div class="col col-md-3">
                    <lable>Tìm kiếm</lable>
                    <input onkeypress="searchData()" id="keyFind" value="{{$key}}" class="form-control" placeholder="Nhập tên bút toán">
                </div>
                <div class="col col-md-2 div-relative-btn">
                    <a href="{{route('admin.category.add')}}" class="btn btn-primary">Thêm mới</a>
                </div>
            </div>
            <div class="container-fluid">
                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Tên bút toán</th>
                            <th>Là chi phí</th>
                            <th>Loại</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>

                        @for ($i  = 0 ; $i < count($data); $i++)
                            <tr>
                                <td>{{$i+1+(($page-1)*$limit)}}</td>
                                <td>{{$data[$i]->accounting_entry_name}}</td>
                                <td>{{$data[$i]->is_cost?"Chi phí":""}}</td>
                                <td>{{$data[$i]->accounting_entry_type=="receive"?"Thu":"Chi"}}</td>
                                <td>
                                    <a href="{{route('admin.accounting_entry.edit', ['id' => $data[$i]->id])}}"><i title="chỉnh sửa" class="fas fa-edit text-primary"></i></a>
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


@endsection

@section('script')
    <script src="/js/accounting_entry/index.js"></script>
@endsection
