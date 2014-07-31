<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="HandheldFriendly" content="true" />
	<title></title>
	{{ HTML::style('css/bootstrap.min.css') }}
	<!-- {{ HTML::style('css/non-responsiveness.css') }} -->
	{{ HTML::style('css/znerg.css') }}	
	{{ HTML::style('css/bootstrap-select.css') }}
	{{ HTML::style('css/jquery.datetimepicker.css') }}
	{{ HTML::style('css/bootstrap-datepicker.css') }}
	<!-- {{ HTML::style('css/bootstrap-datetimepicker.min.css') }} -->
	{{ HTML::style('css/jquery.timepicker.css') }}
	{{ HTML::style('css/ui-lightness/jquery-ui-1.10.3.custom.css') }}
</head>
<body>
	<div class="container">
		<div class="header row well">
			<div class="row">
				<p class="header-company-title text-right">ZnerG</p>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<p class="header-options text-left">
					<span class="glyphicon glyphicon-home"></span> &nbsp; {{ link_to('main', "Home", array('class' => 'no-decoration')) }} &nbsp; 
					<span class="glyphicon glyphicon-log-out"></span> &nbsp; {{ link_to('logout', "Logout", array('class' => 'no-decoration')) }}
					</p>
				</div>
				<div class="col-xs-6">
					<p class="welcome-name header-right text-right">{{ Auth::user()->username }}</p>
				</div>
			</div>
		</div>

			<div class="row">
			@if (Session::has('message'))
			<div class="message col-xs-12">
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<p>{{ Session::get('message') }}</p>
				</div>
			</div>
			@endif
			@if (Session::has('information'))
			<div class="message col-xs-12">
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<p>{{ Session::get('information') }}</p>
				</div>
			</div>
			@endif
			<div class="container menu col-xs-12">
				<div class="row">
					@include('elements.mainMenu')
				</div>
				<div class="row">
					<div class="leftMenu col-xs-2 well hidden-xs">
						@include('elements.menu')
						@yield('linkMenu')
					</div>
					<div class="mainContainer container col-xs-12 visible-xs">
						@yield('content')
					</div>
					<div class="mainContainer container col-xs-10 hidden-xs">
						@yield('content')
					</div>
				</div>
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