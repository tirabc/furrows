<?php

function install()
{

    // The configuration file exists AND
    // the configuration form is not filled
    if( empty( $_REQUEST["config_form_completed"] ) && file_exists( "../config.php" ) )
    {

        // The exists_form is filled
        if( !empty( $_REQUEST["exists_form_completed"] ) )
        {

            // The exists_form is correctly filled and user doesn't want to replace
            if( !empty( $_REQUEST["replace"] ) && $_REQUEST["replace"] == "dontreplace" )
            {
                $data = array( 
                    "class" => "note",
                    "error" => "",
                    "body" => "Note : You can now use the application.",
                    "title" => "That's the end !",
                    "second" => "The application is correctly installed."
                );
                $view_url = "./message.html";
                show_view_data( $view_url , $data );
            }
            // The exists_form is correctly filled and user wants to replace
            else
            {
                // sauvegarde le fichier de config existant
                $now = date("Ymd_h_i_s");
                copy( "../config.php" , "../save." . $now . ".config.php" );

                // on affiche le formulaire suivant


                $view = "./form.html";
                $subview = subview($view);
                $data = array( 
                    "class" => "form",
                    "error" => "",
                    "body" => $subview,
                    "title" => "Warning",
                    "second" => "The configuration file already exists."
                );
                $view_url = "./message.html";
                show_view_data( $view_url , $data );

            }
        }
        // The exists_form has not been filled (1st visit)
        else
        {

            // The configuration file exists
            if( file_exists( "../config.php" ) )
            {

                $view = "./config_exists.html";
                $subview = subview($view);
                $data = array( 
                    "class" => "form",
                    "error" => "",
                    "body" => $subview,
                    "title" => "Warning",
                    "second" => "The configuration file already exists."
                );
                $view_url = "./message.html";
                show_view_data( $view_url , $data );
                
            }
            // The configuration file does not exist
            else{

                $view = "./config_exists.html";
                $subview = subview($view);
                $data = array( 
                    "class" => "form",
                    "error" => "",
                    "body" => $subview,
                    "title" => "Warning",
                    "second" => "The configuration file already exists."
                );
                $view_url = "./message.html";
                show_view_data( $view_url , $data );

            }
            
        }

    }

    // The config_form has been filled
    if( !empty( $_REQUEST["config_form_completed"] ) )
    {

        if( empty( $_REQUEST["mysql_user"] ) ||
            empty( $_REQUEST["mysql_pass"] ) ||
            empty( $_REQUEST["mysql_host"] ) ||
            empty( $_REQUEST["mysql_base"] ) ||
            empty( $_REQUEST["session_name"] ) ||
            empty( $_REQUEST["base_url"] )
        )
        {

            $view = "./form.html";
            $subview = subview($view);
            $data = array( 
                "class" => "form",
                "error" => "<p>Please, fill the form.</p>",
                "body" => $subview,
                "title" => "Oops",
                "second" => "There's something wrong."
            );
            $view_url = "./message.html";
            show_view_data( $view_url , $data );
        }
        else
        {

            $host = mysql_real_escape_string( $_REQUEST["mysql_host"] );
            $base = mysql_real_escape_string( $_REQUEST["mysql_base"] );
            $user = mysql_real_escape_string( $_REQUEST["mysql_user"] );
            $pass = mysql_real_escape_string( $_REQUEST["mysql_pass"] );
            $session_name = htmlentities( $_REQUEST["session_name"] );
            $base_url = htmlentities( $_REQUEST["base_url"] );

	        try {

                // DATABASE
			    $pdo = new PDO( "mysql:host=" . $host . ";dbname=" . $base , $user, $pass );
                $pdo->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
                $sql = file('./database.sql');
                $requetes = "";
			    foreach( $sql as $lecture )
			    {
				    if( substr( trim( $lecture ) , 0 , 2 ) != '--' )
				    { 

				    	// suppression des commentaires et des espaces
				    	$requetes .= $lecture;

				    }
				}
				$reqs = split( ';' , $requetes );
				foreach( $reqs as $req )
				{

                    if( trim( $req ) != '' ) 
    					$pdo->query( $req );
                }

                // CONFIG FILE
                $default = file_get_contents( "./config.default.php" );
                $config_file = str_replace( "{{base_url}}" , $base_url , $default );
                $config_file = str_replace( "{{session_name}}" , $session_name , $config_file );
                $config_file = str_replace( "{{user}}" , $user , $config_file );
                $config_file = str_replace( "{{pass}}" , $pass , $config_file );
                $config_file = str_replace( "{{base}}" , $base , $config_file );
                $config_file = str_replace( "{{host}}" , $host , $config_file );
                if( !file_put_contents( "../config.php" , $config_file ) )
                {
                    throw new Exception( "Error while creating the config.php file." );
                }

                // HTACCESS
                $default = file_get_contents( "./htaccess.default" );
                $htaccess_file = str_replace( "{{base_url}}" , $base_url , $default );
                if( !file_put_contents( "../.htaccess" , $htaccess_file ) )
                {
                    throw new Exception( "Error while creating the .htaccess file." );
                }

                // GREAT, SUCCESS !
                $data = array( 
                    "class" => "note",
                    "error" => "",
                    "body" => "Note : Delete the <code>/install</code> directory.",
                    "title" => "Congratulations !",
                    "second" => "Installation was successful."
                );
                $view_url = "./message.html";
                show_view_data( $view_url , $data );

			}
			catch( PDOException $e )
			{
                $error = $e->getMessage();
                $data = array( 
                    "class" => "error",
                    "error" => "",
                    "body" => $error,
                    "title" => "Sorry !",
                    "second" => "An error occured."
                );
                $view_url = "./message.html";
                show_view_data( $view_url , $data );
			}
			
        }
    }
    // The config form has not been filled (1st visit)
    else
    {
        $view = "./form.html";
        $subview = subview($view);
        $data = array( 
            "class" => "form",
            "error" => "",
            "body" => $subview,
            "title" => "Welcome",
            "second" => "We will install this application."
        );
        $view_url = "./message.html";
        show_view_data( $view_url , $data );
    }

}

function subview( $view )
{
    $html = file_get_contents( $view );
    return $html;
}
function show_view( $view )
{
    $html = file_get_contents( $view );
    echo $html;
    exit;
}
function show_view_data( $view , $data )
{
    $html = file_get_contents( $view );
    foreach ( $data as $key => $value )
    {
        $html = str_replace( "{{" . $key . "}}" , $value , $html );
    }
    echo $html;
    exit;
}

install();

?>