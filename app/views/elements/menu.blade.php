<ul class="nav nav-pills nav-stacked well">
	@if (Auth::user())
		@foreach(Session::get('menuOptions') as $key => $option)
			@if (substr(strval(Session::get('activePage')),0,1) == substr(strval($key),0,1) && substr(strval($key),1,2) != "00" && $option['name']!='-')
				{{ HTML::nav_link($option['link'] . '?activePage=' . $key, $option['name'], $option['level']) }}
			@endif
		@endforeach
	@endif
</ul>
