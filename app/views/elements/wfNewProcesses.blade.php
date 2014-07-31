<ul class="nav well linkMenu">
	<li>
		<p>{{ trans('ui.initialActivities') }}</p>
	</li>
	@if ($initialActivities)
		@foreach($initialActivities as $key => $option)
			<li class='listItems'>{{ link_to($modelName . '/create?id_activitiesProcess=' . $key, '- ' . $option, array('class' => 'no-decoration listItems geoLocation')) }}</li>
		@endforeach
	@endif
</ul>
<!--ul class="nav well linkMenu">
	<li>
		<p>{{ trans('ui.currentPosition') }}</p>
	</li>
	<div id="map-canvas" class="map-canvas"></div>
</ul-->
