

@extends('layouts.admin')
@section('title')
    <title>Quản lý sản phẩm | Thêm mới</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('/css/category/add.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/imageuploadify/imageuploadify.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/ckeditor/samples/css/samples.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <form method="post" action="{{route("admin.product.insert")}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="category_name">Nhập tên sản phẩm</label>
                    <input type="text" class="form-control"  name="product_name" placeholder="Nhập tên sản phẩm" required>
                </div>
                <div class="form-group">
                    <label for="product_price">Seo image</label>
                    <input name="product_seo_image" class="form-control" type="text" placeholder="nhập link ảnh">
                </div>
                <div class="form-group">
                    <label for="product_price">Seo title</label>
                    <input name="product_seo_title" type="text" class="form-control" placeholder="nhập seo title">
                </div>
                <div class="form-group row">
                    <div class="col-6 col-md-6 col-xl-3 col-lg-3">
                        <label for="product_price">Giá nhập</label>
                        <input type="text" class="form-control integer"  value="0" name="product_import_price" placeholder="Nhập giá sản phẩm" oninput="inputNumber()" required>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3 col-lg-3">
                        <label for="product_price">Giá bán</label>
                        <input type="text" class="form-control integer"  value="0" name="product_price" placeholder="Nhập giá sản phẩm" oninput="inputNumber()" required>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3 col-lg-3">
                        <label for="product_price">VAT</label>
                        <input type="text" class="form-control integer"  value="0" name="product_vat" placeholder="Nhập giá sản phẩm" oninput="inputNumber()" required>
                    </div>
                    <div class="col-6 col-md-6 col-xl-3 col-lg-3">
                        <label for="product_price">Chiết khấu</label>
                        <input type="text" class="form-control"  value="0" name="product_tradiscount" placeholder="Nhập giá sản phẩm" oninput="inputNumber()" required>
                    </div>
                    <div class="col-6 col-md-6 col-xl-6 col-lg-6">
                        <label for="product_price">Giá bán ảo</label>
                        <input type="text" class="form-control integer"  value="0" name="product_price_fake" placeholder="Nhập giá sản phẩm" oninput="inputNumber()" required>
                    </div>
                    <div class="col-6 col-md-6 col-xl-6 col-lg-6">
                        <label for="product_price">Part thưởng</label>
                        <input type="text" class="form-control integer"  value="0" name="product_part" placeholder="Nhập part thưởng" oninput="inputNumber()" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Chọn danh mục cha</label>
                    <select name="category_id" required>
                        {!! $html_option_category !!}
                    </select>
                </div>
                <div class="form-group">
                    <b>Bài viết</b>
                    <input class="form-control"  name="product_title_content" placeholder="Nhập tiêu đề bài tiết">
                    <textarea id="editor" name="product_content" value="{{old('product_content','')}}" class="form-control"></textarea>
                </div>
                <div class="form-group" >
                    <b>Ảnh sản phẩm</b>
                    <input id="image_product" name="image_product[]" class="form-control" type="file" accept="image/*" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>

    </div>
@endsection


@section('popup')


@endsection

@section('script')
    @if(session()->has('error'))
            <script>alert('{{session()->get('error')}}')</script>
    @endif
    <script src="{{asset('/assets/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('/assets/imageuploadify/imageuploadify_form.js')}}"></script>
    <script>

        var options = {
            filebrowserImageUploadUrl: '{{route('unisharp.lfm.upload')}}?type=Images&_token='+document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // url post upload
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='+document.querySelector('meta[name="csrf-token"]').getAttribute('content') // đéo biết

        };
        CKEDITOR.replace('editor', options);
    </script>
    <script>
        $('#image_product').imageuploadify();
        // initSample();
    </script>
@endsection
