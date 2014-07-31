<?php

HTML::macro('nav_link', function($route, $text, $level) {    

		$requestPath = Request::path();
		$request = strstr($requestPath, '/', true); 
		if (!$request)
		{
			$request = strstr($requestPath, '?', true); 
			if (!$request)
				$request = $requestPath;
		}

		$routeAux = strstr($route, '/', true); 
		if (!$routeAux)
		{
			$routeAux = strstr($route, '?', true); 
			if (!$routeAux)
				$routeAux = $route;
		}

/*        if ( Request::is($routeAux.'*'))
        {
            $active = "class = 'level" . $level . " active'";
        }*/
        if (starts_with($routeAux, $request))
        {
            $active = "class = 'level" . $level . " active'";
        }
        else
        {
            $active = "class = level" . $level;
        }
        
  	return '<li ' . $active . '>' . link_to($route, $text, array('class' => 'no-decoration')) . '</li>';

});

HTML::macro('button', function($value, $options)
{
   if ( ! array_key_exists('type', $options) )
   {
       $options['type'] = 'button';
   }

    return '<button '. HTML::attributes($options).'>'.$value.'</button>';
});