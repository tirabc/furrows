<?php
/* 
 * configuration
 */

// Répertoires
define( 'DIR_ROOT'			, dirname( __FILE__ ).'/' );
define( 'DIR_APPLICATION'	, DIR_ROOT.'application/' );
define( 'DIR_FRAMEWORK'		, DIR_ROOT.'framework/' );
define( 'DIR_WEBROOT'		, DIR_ROOT.'webroot/' );
define( 'DIR_HELPERS'		, DIR_FRAMEWORK.'helpers/' );
define( 'DIR_MODELS'		, DIR_APPLICATION.'models/' );
define( 'DIR_CONTROLLERS'	, DIR_APPLICATION.'controllers/' );
define( 'DIR_VIEWS'			, DIR_APPLICATION.'views/' );

// Default values
define( 'DEFAULT_CONTROLLER', 'pages' );
define( 'DEFAULT_ACTION'    , 'index' );

// Default names
define( 'NAME_CONTROLLER'   , 'c' );
define( 'NAME_ACTION'       , 'a' );

// Extensions des fichiers
define( 'EXT_MODEL'         , '_model.php');
define( 'EXT_CONTROLLER'	, '_controller.php');
define( 'EXT_VIEW'          , '_view.php' );
define( 'EXT_HELPER'		, '_helper.php' );

// Variables de session
define( 'SESSION'           , 'furrowsdemo' );

// Base de données
define( 'HOST'              , 'localhost' );
define( 'USER'              , 'root' );
define( 'PASS'              , 'root' );
define( 'BASE'              , 'furrowsdemo' );

// Chemin
define( 'ARRAY_BASE_PATH'   , 'http://localhost:8888/furrows/' );

?>
