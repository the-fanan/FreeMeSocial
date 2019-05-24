<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
	
			<!-- CSRF Token -->
			<meta name="csrf-token" content="{{ csrf_token() }}">
			<title>Socially</title>

			<link href="{{ url(mix('css/app.css')) }}" rel="stylesheet" type="text/css">
			<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
			<link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css">
	</head>

	<body>
		@include('includes.nav')

		@yield('content')

		<!-- Scripts -->
		<script src="{{ url(mix('js/app.js')) }}"></script>
		@stack('page-scripts')
	</body>
</html>