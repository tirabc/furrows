<?php

class Pages_controller extends Controller
{
    protected $models = array();

    public function before(){

        global $loader;
        $loader->addPath( DIR_VIEWS."pages/" , "pages" );

    }

    public function index()
    {

        global $twig;

        $template = $twig->loadTemplate( "@pages/index.html" );
        echo $template->render([]);
    }

    public function app()
    {
        global $twig;
        if( empty( $_SESSION[SESSION] ) )
        {
          header( "Location: signin");
        }
        $data = [
          "user" => $_SESSION[SESSION]["user"],
          "base_url" => ARRAY_BASE_PATH
        ];
        $template = $twig->loadTemplate( "@pages/app.html" );
        echo $template->render( $data );
    }

}

?>
