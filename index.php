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

		$value = split('-', $value);

		map($value[0], $value[1], function () use ( $value , $router ) {

		  $router->_controller = $value[2];
		  $router->_action = $value[3];			
	 		$router->route();

		});

	}


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
