<?php

class Users_controller extends Controller
{
  protected $models = array( 'User' );
  protected $helpers = array( 'Input' );

  public function before()
  {

    global $loader;
    $loader->addPath( DIR_VIEWS."users/" , "users" );
    $loader->addPath( DIR_VIEWS."pages/" , "pages" );

  }

  public function index()
  {

    $user_model = new User();
    $users = $user_model->find_all();

    $data["base_url"] = ARRAY_BASE_PATH;
    $data["users"] = $users;

    $view = new Mustache( 'users/index' , $data );
    $view->render();
  }

  public function signin()
  {
    global $twig;
    $data = array();
    if( isset( $_POST["csrf"] ) )
    {
      $keys = array( "email" , "password" );
      $params = Input::filter( $_POST , $keys );
      $password = Input::hash( $params["password"] );
      $email = Input::sanitize( $params["email"] );

      $user_model = new User();
      $users = $user_model->find_all_by( "email" , $email );

      if( count( $users ) > 1 || count( $users ) == 0 )
      {
          $data[ "message" ] = "Error. Users.";
      }
      else
      {
        $user_model->setAttributes( $users[0] );

        if( $user_model->password !== $password )
        {
            $data[ "message" ] = "Error. Password is not correct.";
        }
        else
        {
          $_SESSION[SESSION]["user"] = $user_model->toArray();
          header( "Location: app" );
          exit;
        }

      }

    }

    $template = $twig->loadTemplate( "@users/signin.html" );
    echo $template->render($data);

  }

  public function signout()
  {
    session_destroy();
    header( "Location: ". ARRAY_BASE_PATH );
  }

  public function signup()
  {

    $keys = array( 'username' , 'password' , 'email' );
    $params = Input::filter( $_REQUEST , $keys );

    $user_model = new User();
    $user_model->username = Input::escape_mysql( $params['username'] );
    $user_model->email = Input::escape_mysql( $params['email'] );
    $user_model->password = Input::hash( $params['password'] );
    $user_model->register_date = date("Y-m-d H:i:s");

    $json = new Json();
    $data = array();
    $users = $user_model->find_all_by( "email" , $user_model->email );

    if( count( $users ) > 0 )
    {
        $data[ "message" ] = "Error, email is already used.";
        $json->body = $data;
        $json->render( 500 );
    }

    if( $user_model->add() )
    {
        $data[ "message" ] = "User created";
        $json->body = $data;
        $json->render( 200 );
    }
    else
    {
        $data[ "message" ] = "Error while creating user";
        $json->body = $data;
        $json->render( 500 );
    }

  }

  public function renew_password()
  {

  }

  public function deactivate()
  {

  }

}

?>
