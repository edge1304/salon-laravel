<!doctype html>
<html lang="en">
  <head>
  	<title>Đăng nhập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="{{asset('/css/login/index.css')}}">

	</head>
	<body>
    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
            <button class="close" data-dismiss="alert">x</button>
        </div>
    @endif

	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Hệ thống quản lý Salon</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(/storage/images/logo/login.jpg);"></div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Đăng nhập</h3>
			      		</div>
                        <div class="w-100">
                            <p class="social-media d-flex justify-content-end">
                                <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                            </p>
                        </div>
			      	</div>
                    <form action="/" class="signin-form" method="post">
                    @csrf
                        <div class="form-group mb-3">
                            <label class="label" for="name">Tên đăng nhập</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>

                        </div>
                        <div class="form-group mb-3">
                            <label class="label" for="password">Mật khẩu</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        </div>
{{--                        <div class="form-group mb-3">--}}
{{--                            <label class="label" for="password">Chọn cơ sở</label>--}}
{{--                            <select name="id_branch" class="form-control" required>--}}
{{--                                <option value="">_______________________</option>--}}
{{--                                {!!$htmlBranch!!}--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <button type="submit"  class="form-control btn btn-primary rounded submit px-3">Đăng nhập</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50 text-left">
                                <label class="checkbox-wrap checkbox-primary mb-0">Nhớ mật khẩu
                                    <input type="checkbox" name="remember_me" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-50 text-md-right">
                                <a href="#">Quên mật khẩu</a>
                            </div>
                        </div>
		            </form>

		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

    <script src="/js/login/jquery.min.js"></script>
    <script src="/js/login/popper.js"></script>
    <script src="/js/login/bootstrap.min.js"></script>
{{--    <script src="/js/login/main.js"></script>--}}

	</body>
</html>

