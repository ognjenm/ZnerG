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
      <p class="navbar-option visible-xs" href="#">{{ Helper::getOptionName(Session::get('activePage')) }}:</p>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
		@if (Session::get('authInsert') || Auth::user()->id == 1)			
			<li class="dropdown btn-xs">{{ link_to_route($modelName . '.create', trans('ui.new'), null , array('class' => 'menuButton dropdown')) }}</li>
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
					 'id' => 'searchForm', 'name' => 'searchForm')) }}
		<span class="searchBox input-group input-group-xs">
			{{ Form::text('searchField', Input::get('searchField'), array('class' => 'form-control searchBox')) }}
			<span class="input-group-btn">
				{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm')) }}
			</span>
		</span>
	@foreach ($dataArray as $key => $value)
		@if (Auth::user()->id == 1 || $key != 'id_organization')
	    <span class="dropdown">
			{{ Form::select($key, $value, $id_filterValues[$key], array('class' => 'dropdown selectpicker', 'onchange' => 'ddField();')) }}
	    </span>
		@endif
	@endforeach

	{{ Form::close() }}
</nav>
