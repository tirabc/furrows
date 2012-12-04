<?php

/*
 * index.php
 * @note : bootstrap
 */

try
{
	// includes
	require_once( './config.php' );
	require_once( DIR_FRAMEWORK.'Front_controller.php' );
	require_once( DIR_FRAMEWORK.'Controller.php' );
	require_once( DIR_FRAMEWORK.'Model.php' );
	require_once( DIR_FRAMEWORK.'View.php' );
	require_once( DIR_FRAMEWORK.'Json.php' );
	require_once( DIR_FRAMEWORK.'Html.php' );
	
	// sessions
	session_start();
	
	// init
	$front_controller = new Front_controller();
	
	$front_controller->set_pdo( HOST, USER, PASS, BASE );
	$pdo = $front_controller->get_pdo();
	
	// route !	
    $front_controller->route();

}
catch( Exception $e )
{
	$view = new View();
	$view->__set('status',500);
	$view->__set('message',$e->getMessage());
	$view->__set('body',$e->getMessage());
	$view->render();
}

?>
