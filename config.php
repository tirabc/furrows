<?php
/* 
 * configuration
 */

// Répertoires
define( 'DIR_ROOT'			, dirname( __FILE__ ).'/' );
define( 'DIR_APPLICATION'	, DIR_ROOT.'application/' );
define( 'DIR_FRAMEWORK'		, DIR_ROOT.'framework/' );
define( 'DIR_HELPERS'		, DIR_FRAMEWORK.'helpers/' );
define( 'DIR_MODELS'		, DIR_APPLICATION.'models/' );
define( 'DIR_CONTROLLERS'	, DIR_APPLICATION.'controllers/' );
define( 'DIR_VIEWS'			, DIR_APPLICATION.'views/' );

// Default values
define( 'DEFAULT_CONTROLLER', 'Editor' );
define( 'DEFAULT_ACTION'    , 'init' );

// Default names
define( 'NAME_CONTROLLER'   , 'c' );
define( 'NAME_ACTION'       , 'a' );

// Extensions des fichiers
define( 'EXT_MODEL'         , '_model.php');
define( 'EXT_CONTROLLER'	, '_controller.php');
define( 'EXT_VIEW'          , '_view.php' );
define( 'EXT_HELPER'		, '_helper.php' );

// Variables de session
define( 'SESSION'           , 'cb' );

// Base de données
define( 'HOST'              , '127.0.0.1' );
define( 'USER'              , 'root' );
define( 'PASS'              , '' );
define( 'BASE'              , 'cb' );

?>
