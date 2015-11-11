<?php

class Pages_controller extends Controller
{
    protected $models = array( 'Page' );
  
    public function before()
    {
        global $loader;
        $loader->addPath( DIR_VIEWS."pages/" , "pages" );
    }

    public function index()
    {

        global $twig;

        $template = $twig->loadTemplate( "@pages/index.html" );
        echo $template->render($data);
    }

}

?>