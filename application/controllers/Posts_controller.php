<?php

class Posts_controller extends Controller
{
    protected $models = array( 'Post' );
    protected $helpers = array( 'Input' );

    public function before()
    {
        global $loader;
        $loader->addPath( DIR_VIEWS."posts/" , "posts" );
    }

    // Dans une méthode de controleur, on peut récupérer les paramètres de 3
    // manières différentes en fonction des besoins:
    // - soit dans les parenthèses de la méthode. Ex.: public function show_auteur($auteur)
    // - soit dans le corps de la méthode avec $_REQUEST
    // - soit dans le corps de la méthode avec : global $router; $args = $router->_args;
    // Il n'y a pas de cas indiqué pour utiliser telle ou telle manière, c'est en fonction du choix du
    // développeur.
    public function index()
    {
        $post_model = new Post();
        $posts = $post_model->find_all();
        $data["base_url"] = ARRAY_BASE_PATH;
        $data["posts"] = $posts;

        global $twig;
        $template = $twig->loadTemplate( "@posts/index.html" );
        echo $template->render($data);
    }

    public function show_auteur($auteur)
    {
        $data["base_url"] = ARRAY_BASE_PATH;
        $data["auteur"] = $auteur;

        global $twig;
        $template = $twig->loadTemplate( "@posts/show_auteur.html" );
        echo $template->render($data);
    }

    public function get_params()
    {
      global $router;
      $args = $router->_args;

      echo "<pre>";
      var_dump($args);
      echo "</pre>";
    }

    public function test()
    {
      $post = new Post();
      $p = $post->find_by_id(1);
      var_dump($post);
      $p->say_hello();
    }

}

?>
