<?php

class Posts_controller extends Controller
{
    protected $models = array( 'Post' );

    public function before()
    {
        global $loader;
        $loader->addPath( DIR_VIEWS."posts/" , "posts" );
    }
  
    public function index()
	{
        
        $post_model = new Post();
        $posts = $post_model->find_all();

        $data["base_url"] = ARRAY_BASE_PATH;
        $data["posts"] = $posts;

        //$error::show( 404 );

        global $twig;

        $template = $twig->loadTemplate( "@posts/index.html" );
        echo $template->render($data);
    
    }

}

?>