<?php

class Posts_controller extends Controller
{
    protected $models = array( 'Post' );
  
    public function index()
	{
        $post_model = new Post();
        $posts = $post_model->find_all();

        $data["base_url"] = ARRAY_BASE_PATH;
        $data["posts"] = $posts;

        $view = new Mustache( 'posts/index' , $data );
		$view->render();
    }

}

?>