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
		{{ Form::open(array('url' => array($modelName . '/search'),
						 'method' => 'GET',
						 'class' => 'navbar-form navbar-left form-horizontal form-standard subMenu',
						 'id' => 'searchForm', 'name' => 'searchForm', 'role' => 'search')) }}
			<span class="searchBox input-group input-group-xs hidden-xs">
				<span class="col-xs-8 searchBox">
					{{ Form::text('searchField', Input::get('searchField'), array('class' => 'form-control')) }}
				</span>
				<span class="input-group-btn col-xs-4 searchBox">
					{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm searchBox')) }}
				</span>
			</span>
			<span class="searchBox input-group input-group-xs visible-xs">
				<span class="col-xs-6 searchBox">
					{{ Form::text('searchField', Input::get('searchField'), array('class' => 'form-control')) }}
				</span>
				<span class="input-group-btn col-xs-6 searchBox">
					{{ Form::submit(trans('ui.search'), array('class' => 'btn btn-default btn-sm searchBox')) }}
				</span>
			</span>
		{{ Form::close() }}
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!-- <nav class="navbar navbar-default secondaryMenu" role="navigation">	
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
 -->