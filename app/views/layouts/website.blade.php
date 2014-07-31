<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	{{ HTML::style('css/bootstrap.css')}}
	{{ HTML::style('css/non-responsiveness.css')}}
	{{ HTML::style('css/znerg.css') }}
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-12 well row header">
				 	<div class="col-3 header-left"><p class="welcome-name"></p></div>
				 	<div class="col-6 header-center"><h1 class="text-center">ZnerG</h1></div>
				 	<div class="col-3 header-right">
						<div class="col-12">
						</div>
						<div class="col-12">
							<p class="header-options text-right">{{ link_to('#', "Home") }} &nbsp; {{ link_to('#', "Contact Us") }}</p>						
						</div>
				 	</div>				
			</div>
		</div>
		<div class="row">
			@if (Session::has('message'))
			<div class="message col-12">
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<p>{{ Session::get('message') }}</p>
				</div>
			</div>
			@endif
			<div class="menu col-2">
				@yield('menu')
			</div>
			<div class="content col-10 well">
				@yield('content')
			</div>
		</div>		{{ HTML::script('js/jquery.js')}}
		{{ HTML::script('js/bootstrap.js')}}
		@yield('scripts')
	</div>
</body>
</html>