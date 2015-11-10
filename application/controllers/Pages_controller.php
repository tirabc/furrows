<?php

class Pages_controller extends Controller
{
    protected $models = array( 'Page' );
  
    public function index()
    {
        /*$page_model = new Page();
        $pages = $page_model->find_by_slug( "index" );

        $data["base_url"] = ARRAY_BASE_PATH;
        $data["page"] = $page;*/

        //$error::show( 404 );
        

        $view = new Mustache( 'pages/index' , $data );
        $view->render();
    }

}

?>