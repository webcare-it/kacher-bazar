<!doctype html>
<html lang="en" class="semi-dark">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('backend/assets/') }}/images/favicon-32x32.png" type="image/png" />

    <div class="d-none">

    </div>
	<!--plugins-->
	@include('admin.includes.style')
	@stack('style')
	<title>Admin dashboard</title>
    <style>
        .cke_notification {
            display: none !important;
        }
    </style>
</head>

<body>
    <div class="d-none">

    </div>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<h4 class="logo-text"><a href="{{ url('/admin/dashboard') }}" class="text-white">Dashboard</a></h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			@include('admin.includes.sidebar')
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		@include('admin.includes.header')
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-content">
			@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif
			@if(session('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					{{ session('error') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif
			@if($errors->any())
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<ul class="mb-0">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif
			@yield('content')
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © {{date('Y')}}. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!--start switcher-->
{{--	<div class="switcher-wrapper">--}}
{{--		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>--}}
{{--		</div>--}}
{{--		<div class="switcher-body">--}}
{{--			<div class="d-flex align-items-center">--}}
{{--				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>--}}
{{--				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>--}}
{{--			</div>--}}
{{--			<hr/>--}}
{{--			<h6 class="mb-0">Theme Styles</h6>--}}
{{--			<hr/>--}}
{{--			<div class="d-flex align-items-center justify-content-between">--}}
{{--				<div class="form-check">--}}
{{--					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>--}}
{{--					<label class="form-check-label" for="lightmode">Light</label>--}}
{{--				</div>--}}
{{--				<div class="form-check">--}}
{{--					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">--}}
{{--					<label class="form-check-label" for="darkmode">Dark</label>--}}
{{--				</div>--}}
{{--				<div class="form-check">--}}
{{--					<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">--}}
{{--					<label class="form-check-label" for="semidark">Semi Dark</label>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<hr/>--}}
{{--			<div class="form-check">--}}
{{--				<input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">--}}
{{--				<label class="form-check-label" for="minimaltheme">Minimal Theme</label>--}}
{{--			</div>--}}
{{--			<hr/>--}}
{{--			<h6 class="mb-0">Header Colors</h6>--}}
{{--			<hr/>--}}
{{--			<div class="header-colors-indigators">--}}
{{--				<div class="row row-cols-auto g-3">--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor1" id="headercolor1"></div>--}}
{{--					</div>--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor2" id="headercolor2"></div>--}}
{{--					</div>--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor3" id="headercolor3"></div>--}}
{{--					</div>--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor4" id="headercolor4"></div>--}}
{{--					</div>--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor5" id="headercolor5"></div>--}}
{{--					</div>--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor6" id="headercolor6"></div>--}}
{{--					</div>--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor7" id="headercolor7"></div>--}}
{{--					</div>--}}
{{--					<div class="col">--}}
{{--						<div class="indigator headercolor8" id="headercolor8"></div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
	<!--end switcher-->
	<!-- Bootstrap JS -->
	@include('admin.includes.script')
    @stack('script')

</body>

</html>
