<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="HandheldFriendly" content="true" />
	<title></title>
	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/datepicker.css') }}
	{{ HTML::style('css/znerg.css') }}
	{{ HTML::style('css/bootstrap-select.css') }}
</head>
<body>
	<div class="container">
		<div class="row">
			@if (Session::has('message'))
			<div class="message col-xs-12">
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<p>{{ Session::get('message') }}</p>
				</div>
			</div>
			@endif
			<div class="content col-xs-12 text-center visible-xs">
				@yield('content')
			</div>
			<div class="content col-sm-offset-4 col-xs-4 text-center hidden-xs">
				@yield('content')
			</div>
		</div>
		{{ HTML::script('js/jquery.js')}}
		{{ HTML::script('js/jquery-ujs.js')}}
		{{ HTML::script('js/bootstrap.min.js')}}
		{{ HTML::script('js/bootstrap-select.js')}}
		@yield('scripts')
	</div>
</body>
</html>