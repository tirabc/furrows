<?php

class Users_controller extends Controller
{
    protected $models = array( 'User' );

    public function before()
    {
        global $loader;
        $loader->addPath( DIR_VIEWS."users/" , "users" );
    }
  
    public function index()
    {

        global $twig;
        $data = array();

        $template = $twig->loadTemplate( "@users/index.html" );
        echo $template->render($data);
    }

}

?>