@if (!Session::has('errorModal'))
	@if ($errors->any())
		<div class="alert alert-danger small">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			{{ implode('', $errors->all('<li class="error">:message</li>')) }}			
		</div>
	@endif
@endif
