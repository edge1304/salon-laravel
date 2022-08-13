

@extends('layouts.admin')
@section('title')
    <title>Quản lý sổ quỹ | Thêm mới</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')

@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container">
            <form method="post" action="{{route("admin.fundbook.insert")}}" >
                @csrf
                <div class="form-group">
                    <label for="fundbook_name">Nhập tên sổ quỹ</label>
                    <input type="text" class="form-control"  name="fundbook_name" placeholder="Nhập tên sổ quỹ" required>
                </div>
                <div class="form-group">
                    <label for="fundbook_type">Chọn loại:</label>
                    <select name="fundbook_type">
                        {!! $html_type !!}
                    </select>
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
