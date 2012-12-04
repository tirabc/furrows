<?php
/* 
 * configuration
 */

// Don't touch this !!!

// Répertoires
define( 'DIR_ROOT'			, dirname( __FILE__ ).'/' );
define( 'DIR_APPLICATION'	, DIR_ROOT.'application/' );
define( 'DIR_FRAMEWORK'		, DIR_ROOT.'framework/' );
define( 'DIR_MODELS'		, DIR_APPLICATION.'models/' );
define( 'DIR_CONTROLLERS'	, DIR_APPLICATION.'controllers/' );
define( 'DIR_VIEWS'			, DIR_APPLICATION.'views/' );

// Extensions des fichiers
define( 'EXT_MODEL'         , '_model.php');
define( 'EXT_CONTROLLER'	, '_controller.php');
define( 'EXT_VIEW'          , '_view.php' );
define( 'EXT_HELPER'		, '_helper.php' );

// Now, you can touch ...

// Default values
define( 'DEFAULT_CONTROLLER', '' ); // define your default controller
define( 'DEFAULT_ACTION'    , '' ); // define your default action

// Default names
define( 'NAME_CONTROLLER'   , 'c' );
define( 'NAME_ACTION'       , 'a' );

// Variables de session
define( 'SESSION'           , 'furrows' );

// Base de données
define( 'HOST'              , 'localhost' );
define( 'USER'              , 'root' ); // define your own database username
define( 'PASS'              , 'root' ); // define your own database password
define( 'BASE'              , 'furrows' ); // define the database name

?>
