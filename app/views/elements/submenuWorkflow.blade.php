<nav id="secondaryMenu" class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-option visible-xs" href="#" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">{{ Helper::getOptionName(Session::get('activePage')) }}:</a>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
		@if ((Session::get('authInsert') || Auth::user()->id == 1) && $initialActivities)			
		<li class="dropdown btn-xs hidden-xs">
			<a href="#" class="menuButton dropdown-toggle" data-toggle="dropdown">{{ trans('ui.new') }}&nbsp;<b class="caret"></b></a>
			<ul class="dropdown-menu btn-xs">
				@if ($initialActivities)
					@foreach($initialActivities as $key => $option)
						<li class='dropdown btn-xs'>{{ link_to($modelName . '/create?id_activitiesProcess=' . $key, $option, array('class' => 'geoLocation')) }}</li>
					@endforeach
				@endif
			</ul>
		</li>
		<!-- Visible only for xs -->
		@if ($initialActivities)
			@foreach($initialActivities as $key => $option)
				<li class='dropdown btn-xs visible-xs'>{{ link_to($modelName . '/create?id_activitiesProcess=' . $key, $option, array('class' => 'geoLocation')) }}</li>
			@endforeach
		@endif
		@endif
		<li class="dropdown btn-xs">
			<a href="#" class="menuButton dropdown-toggle" data-toggle="dropdown">{{ trans('ui.actions') }}&nbsp;<b class="caret"></b></a>
			<ul class="dropdown-menu btn-xs">
				<li class="dropdown btn-xs"><a href="#">{{ trans('ui.config') }}</a></li>
				<li class="dropdown btn-xs"><a href="#">{{ trans('ui.export') }}</a></li>
		    	<li class="dropdown btn-xs"><a href="javascript:printArea();">{{ trans('ui.print') }}</a></li>
				<li class="divider"></li>
				<li class="dropdown btn-xs"><a href="#">{{ trans('ui.deleteAll') }}</a></li>
			</ul>
		</li>
      </ul>
		{{ Form::open(array('url' => array($modelName . '/search'),
						 'method' => 'GET',
						 'class' => 'navbar-form navbar-left form-horizontal form-standard subMenu',
						 'id' => 'searchForm', 'name' => 'searchForm', 'role' => 'search')) }}
			<span class="searchBox input-group input-group-xs hidden-xs">
				<span class="col-xs-8 searchBox">
					{{ Form::text('searchField', $input, array('class' => 'form-control')) }}
				</span>
				<span class="input-group-btn col-xs-4 searchBox">
					{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm searchBox')) }}
				</span>
			</span>
			<span class="searchBox input-group input-group-xs visible-xs">
				<span class="col-xs-6 searchBox">
					{{ Form::text('searchField', $input, array('class' => 'form-control')) }}
				</span>
				<span class="input-group-btn col-xs-6 searchBox">
					{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm searchBox')) }}
				</span>
			</span>
		@if (count($collaborators) > 2)
		    <span class="dropdown hidden-xs">
				{{ Form::select('id_employee', $collaborators, $id_employee, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
		    </span>
		    <span class="dropdown visible-xs">
				{{ Form::select('id_employee', $collaborators, $id_employee, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
		    </span>
		@endif
		@if (count($campaigns) > 1)
		    <span class="dropdown hidden-xs">
				{{ Form::select('id_campaign', $campaigns, $id_campaign, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
		    </span>
		    <span class="dropdown visible-xs">
				{{ Form::select('id_campaign', $campaigns, $id_campaign, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
		    </span>
		@endif
		@if (Auth::user()->id == 1)	
		    <span class="dropdown hidden-xs">
				{{ Form::select('id_organization', $organizations, $id_organization, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
		    </span>
		    <span class="dropdown visible-xs">
				{{ Form::select('id_organization', $organizations, $id_organization, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
		    </span>
		@endif
	    <span class="dropdown">
			{{ Form::select('id_day', $days, $id_day, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
	    </span>
	    <span class="dropdown">
			{{ Form::select('id_statusTask', $statusTasks, $id_statusTask, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
	    </span>
	    <span class="dropdown">
			{{ Form::select('id_activitiesProcess', $activities, $id_activitiesProcess, array('class' => 'dropdown form-control selectpicker', 'onchange' => 'ddField();')) }}
	    </span>
		{{ Form::close() }}
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>