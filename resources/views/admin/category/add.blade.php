

@extends('layouts.admin')
@section('title')
    <title>Quản lý danh mục | Thêm mới</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/css/category/add.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <form method="post" action="{{route("admin.category.insert")}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="category_name">Nhập tên danh mục</label>
                    <input type="text" class="form-control"  name="category_name" placeholder="Nhập tên danh mục" required>
                </div>
                <div class="form-group">
                    <label>Chọn danh mục cha</label>
                    <select name="id_parent" required>
                        <option value="0">____________</option>
                        {!! $html_option_category !!}
                    </select>
                </div>
                <div class="form-group" id="div-group-select-image">
                    <label>Chọn ảnh</label>
                    <input type="file" name="image" id="input_add_image" class="input-select-image" accept="image/*">
                    <div class="div-select-image">
                        <img>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>

    </div>
@endsection


@section('popup')


@endsection

@section('script')

@endsection
