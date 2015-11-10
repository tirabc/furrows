<?php

class Users_controller extends Controller
{
    protected $models = array( 'User' );
  
    public function index()
    {

        $user_model = new User();
        $users = $user_model->find_all();

        $data["base_url"] = ARRAY_BASE_PATH;
        $data["users"] = $users;

        $view = new Mustache( 'users/index' , $data );
        $view->render();
    }

}

?>