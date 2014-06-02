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
	require_once( DIR_FRAMEWORK.'iRenderView.php' );
	require_once( DIR_FRAMEWORK.'Json.php' );
	require_once( DIR_FRAMEWORK.'Xslt.php' );
	require_once( DIR_FRAMEWORK.'Html.php' );
	require_once( DIR_FRAMEWORK.'Mustache.php' );
	require_once( DIR_FRAMEWORK.'libs/Mustache/Autoloader.php' );
	
	// init
	$router = new Router();
	
	$router->set_pdo( HOST, USER, PASS, BASE );
	$pdo = $router->get_pdo();
	
	// load mustache
	Mustache_Autoloader::register();

	// route !	
    $router->route();

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
