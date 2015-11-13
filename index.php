<?php

/*
 * index.php
 * @note : bootstrap
 */

try
{

	// includes

	require_once( './config.php' );
	require_once( DIR_FRAMEWORK.'helpers/Dispatch_helper.php' );
	require_once( DIR_FRAMEWORK.'Router.php' );
	require_once( DIR_FRAMEWORK.'Controller.php' );
	require_once( DIR_FRAMEWORK.'Model.php' );
	require_once( DIR_FRAMEWORK.'View.php' );
	require_once( DIR_FRAMEWORK.'Json.php' );
	require_once( DIR_FRAMEWORK.'libs/Twig/Autoloader.php' );


	// config

	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem( DIR_VIEWS );
	$twig = new Twig_Environment($loader, array(
	  'debug' => true
	));
	$loader->addPath( DIR_VIEWS."common/" , "common" );
	config('url', 'http://localhost:8888/furrows/');


	// init

	$router = new Router();
	$router->set_pdo( HOST, USER, PASS, BASE );
	$pdo = $router->get_pdo();
	$routes = parse_ini_file( './routes.ini' );
	
	foreach ($routes["routes"] as $key => &$value) {

		$value = explode('-', $value);

		map($value[0], $value[1], function () use ( $value , $router ) {

		  $router->_controller = $value[2];
		  $router->_action = $value[3];		
		 	
	 		$router->route();

		});

	}

	map(function () use ( $router) {

			  $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			  $path = trim($path, '/');

			  # strip url from request URI
			  if ($base = config('url')) {
			    $base = trim(parse_url($base, PHP_URL_PATH), '/');
			    $path = preg_replace('@^'.preg_quote($base).'@', '', $path);
			  }


        // couper l'url de la forme : /mon/url
        $data = explode( '/' , $path );
        $arr = array_reverse( array_filter( $data ) );

        // récupérer le controleur (1er element du tableau)
        $router->_controller = array_pop( $arr );

        // récupérer l'action (2eme element du tableau)
        $router->_action = array_pop( $arr );

        // tous les autres elements sont des parametres sous la forme : monparametre:mavaleur
        foreach( $arr as $cell )
        {
            // creer un tableau depuis la string "monparametre:mavaleur"
            $params = explode( ':' , $cell );
            // $params[0] = "monparamtre"
            // $params[1] = "mavaleur"
            // on ré-injecte les parametres dans le tableau $_REQUEST
            $_REQUEST[ $params[0] ] = $params[1];
        }
        $router->_args = $_REQUEST;

        $router->route();

	});

	map(404, function ($code, $res) {
  var_dump($code,$res);
});


	// start!

	dispatch();

}
catch( Exception $e )
{
	echo "<pre>";
	var_dump($e);
	echo "</pre>";
}

?>
