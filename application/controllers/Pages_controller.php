<?php

class Pages_controller extends Controller
{
    protected $models = array( 'Page' );

    protected function before()
    {
        global $loader;
        $loader->addPath( DIR_VIEWS."pages/" , "pages" );
    }

    public function index( $test = null )
    {

        global $twig;
        
        if( isset( $test ) )
          echo "<pre>".$test."</pre>";

        $template = $twig->loadTemplate( "@pages/index.html" );
        echo $template->render([]);
    }

    public function test( $monargument = '' )
    {
        var_dump($monargument);
        echo "test réussi";
    }

}

?>
