<nav id="mainMenu" class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      @if ((Session::has('nestedRoutePath')) && Session::has('nestedCall') == 'Yes')
      <button type="button" class="navbar-toggle">
        <a href="{{ URL::route(Session::get('nestedRoutePath')) }}" class="glyphicon glyphicon-circle-arrow-left" style="color:#fff"></a>
      </button>
      @endif
      <a class="navbar-brand" href="#" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">{{ Session::get('shortName') }}</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        @if (Auth::user())
          @foreach(Session::get('menuOptions') as $key => $option)
            @if ($option['level'] > 0)
              @if ($option['dropdown'] == 'No')
                @if (isset($option['name']) && $option['name'] == '-')
                <li class="divider"></li>
                @else
                  @if (Session::get('activePage') == $key && substr(strval($key),1,2) == "00")
                    <li class="active">
                  @else
                    <li>
                  @endif
                    {{ link_to($option['link'] . '?activePage=' . $key, $option['name'], array('class' => 'menuButton', 'id' => 'menuItem'.$key)) }}
                  </li>
                @endif
              @else          
                @if (substr(strval(Session::get('activePage')),0,1) == substr(strval($key),0,1))
                  <li class="dropdown active" id="menuItem{{ $key }}">
                @else
                  <li class="dropdown" id="menuItem{{ $key }}">
                @endif
                  <a href="{{ $option['link'] }}" class="dropdown-toggle menuButton" data-toggle="dropdown">{{ $option['name'] }}&nbsp;<b class="caret"></b></a>
                  <ul class="dropdown-menu">
              @endif
              @if ($option['closeDropdown'] == 'Yes')
                </ul>
              </li>
              @endif
            @endif
          @endforeach
        @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
