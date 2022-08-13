<!DOCTYPE html>

<html lang="en">
@include('partials.head')
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    @include('partials.header')

    @include("partials/sidebar")

    @yield("content")

    @include("partials/footer")
    </div>

    @yield("popup")

    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.js')}}"></script>
    <script src="{{asset('assets/swal/sweetalert2.all.js')}}"></script>
    <script src="{{asset('js/CONST.js')}}"></script>
    <script src="{{asset('js/helper.js')}}"></script>
    @yield("script")
</body>
</html>
