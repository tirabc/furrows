<?php

/*
 * index.php
 * @note : bootstrap
 */

try
{

	// includes
	require_once( './config.php' );
	require_once( DIR_FRAMEWORK.'Router.php' );
	require_once( DIR_FRAMEWORK.'Controller.php' );
	require_once( DIR_FRAMEWORK.'Model.php' );
	require_once( DIR_FRAMEWORK.'View.php' );
	require_once( DIR_FRAMEWORK.'Json.php' );
	require_once( DIR_FRAMEWORK.'libs/Twig/Autoloader.php' );
	require_once( DIR_FRAMEWORK.'libs/Idiorm/idiorm.php' );
	require DIR_FRAMEWORK . 'libs/Slim/Slim.php';

	// config
	\Slim\Slim::registerAutoloader();
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem( DIR_VIEWS );
	$twig = new Twig_Environment($loader, array(
	  'debug' => true
	));
	$loader->addPath( DIR_VIEWS."common/" , "common" );

	$app = new \Slim\Slim(array(
	    'debug' => true,
			'mode' => 'development'
	));

	$routes = parse_ini_file( './routes.ini' , true );

	function parse( $group , $app )
	{
		foreach($group as $route){
			$_route = explode(" ", $route);
			$app->map($_route[1], function () use($_route) {
				global $router;
				$router->_controller = ucfirst($_route[2]);
				$router->_action = strtolower($_route[3]);
				$router->_args = func_get_args();
				$router->route();
			})->via($_route[0]);
		}
	}

	$router = new Router();
	$router->set_pdo( HOST, USER, PASS, BASE );
	foreach( $routes as $key => $group )
	{

		if( $key == "default" ){
			parse($group,$app);
		}else{
			$app->group( $key , function () use ($app,$group) {

				parse($group,$app);
			});
		}
	}

	$app->notFound(function () use ($app) {
		echo "ERROR";
	});

	$app->run();

}
catch( Exception $e )
{
	echo "<pre>";
	var_dump($e);
	echo "</pre>";
}

?>
