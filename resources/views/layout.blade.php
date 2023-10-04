<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{$title}}</title>
	<link rel="icon" href="{{ asset('storage/setting/default_favicon.png') }}" type="image/x-icon" />
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/font-awesome-animation.min.css') }}">
	<!-- flag-icon -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="{{ asset('assets/dist/cdn/ionicons.min.css') }}">
	<!-- pace-progress -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/pace-progress/themes/black/pace-theme-flat-top.css') }}">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
	<!-- menu -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- toastr -->
	<link rel="stylesheet" href="{{ asset('assets/dist/cdn/toastr.min.css') }}">
	<!-- custom -->
	<link rel="stylesheet" href="{{ asset('assets/dist/css/custom.css') }}">
	<style type="text/css">
		.table td, .table th{
			padding: 3px;
		}
		.required{
			font-weight: 800;
			color: red;
		}
	</style>
	@stack('css')
	<script>
		var base_url = {!! json_encode(url('/')) !!};
	</script>
</head>
<body class="hold-transition sidebar-mini pace-primary layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">
		@include('include.top_navbar')
		@include('include.sidebar')
		@yield('content')
		<a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="@lang('cmn.scroll_to_top')">
			<i class="fas fa-chevron-up"></i>
		</a>
		@include('include.footer')
	</div>
	<!-- jQuery -->
	<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
	<!-- select -->
	<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- pace -->
	<script src="{{ asset('assets/plugins/pace-progress/pace.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
	<!-- menu -->
	<!-- AdminLTE for demo purposes -->
	<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
	<script src="{{ asset('assets/dist/js/sweetalert2.all.js') }}"></script>
	<script>
		$('.select2').select2();
	</script>
	@stack('js')
	<!-- toastr -->
	<script src="{{ asset('assets/dist/cdn/toastr.min.js') }}"></script>
	{!! Toastr::message() !!}	
</body>
</html>