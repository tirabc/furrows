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
	//require_once( DIR_FRAMEWORK.'Mustache.php' );
	//require_once( DIR_FRAMEWORK.'libs/Mustache/Autoloader.php' );
	require_once( DIR_FRAMEWORK.'libs/Twig/Autoloader.php' );

	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem( DIR_VIEWS );
	$twig = new Twig_Environment($loader, array(
	  'debug' => true
	));
	$loader->addPath( DIR_VIEWS."posts/" , "posts" );
	$loader->addPath( DIR_VIEWS."common/" , "common" );

	// init
	$router = new Router();
	
	$router->set_pdo( HOST, USER, PASS, BASE );
	$pdo = $router->get_pdo();
	
	// load mustache
	//Mustache_Autoloader::register();

	// add dispatch lib here
	config('url', 'http://localhost:8888/furrows/');

	$routes = parse_ini_file( './routes.ini' );
	
	foreach ($routes["routes"] as $key => &$value) {

		$value = split('-', $value);

		# map a handler that expects the db conn
		map($value[0], $value[1], function () use ( $value , $router ) {

		  $router->_controller = $value[2];
		  $router->_action = $value[3];		
		  // route !	
	 		$router->route();

		});

	}

	# args you pass to dispatch() gets forwarded
	dispatch();


}
catch( Exception $e )
{
	$view = new View();
	$view->__set( 'status' , 500 );
	$view->__set( 'message' , $e->getMessage() );
	$view->__set( 'body' , $e->getMessage() );
	$view->render();
}

?>
