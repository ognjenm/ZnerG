<ul class="nav nav-pills nav-stacked well table-condensed">
	@foreach($menuOptions as $option)
		{{ HTML::nav_link($option['link'], $option['name'], $option['level']) }}
	@endforeach
</ul>
