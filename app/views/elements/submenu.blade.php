<nav class="navbar navbar-default secondaryMenu" role="navigation">	
	<ul class="nav navbar-nav col-3">
		@if (Session::get('authInsert') || Auth::user()->id == 1)			
			<li class="btn-xs">{{ link_to_route($modelName . '.create', trans('ui.new'), null , array()) }}</li>
		@else
			<li class="btn-xs disabled">{{ link_to('#', trans('ui.new'), null , array('disabled' => 'disabled')) }}</li>
		@endif
		<li class="dropdown btn-xs">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('ui.actions') }}&nbsp;<b class="caret"></b></a>
			<ul class="dropdown-menu btn-xs">
				<li class="dropdown btn-xs"><a href="#">{{ trans('ui.config') }}</a></li>
				<li class="dropdown btn-xs"><a href="#">{{ trans('ui.export') }}</a></li>
	        	<li class="dropdown btn-xs"><a href="javascript:printArea();">{{ trans('ui.print') }}</a></li>
				<li class="divider"></li>
				<li class="dropdown btn-xs"><a href="#">{{ trans('ui.deleteAll') }}</a></li>
			</ul>
		</li>
	</ul>
	<ul class="nav navbar-nav col-9">					
		{{ Form::open(array('url' => array($modelName . '/search'),
						 'method' => 'GET',
						 'class' => 'navbar-form navbar-left form-horizontal form-standard subMenu',
						 'id' => 'searchForm', 'name' => 'searchForm')) }}
			<li>
				<div class="searchBox input-group input-group-xs col-8">
					{{ Form::text('searchField', Input::get('searchField'), array('class' => 'form-control searchBox')) }}
					<span class="input-group-btn">
						{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm')) }}
					</span>
				</div>
			</li>				
		{{ Form::close() }}
	</ul>
</nav>
