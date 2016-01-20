<?php

/**
 * Front_controller
 *
 * @author christian barras
 */
class Router
{

    private $_pdo;

    public $_controller;
    public $_action;
    public $_args;

    /*
     * get_controller()
     * @note : permet de retourner le controleur
     * @return : string
     */
    public function get_controller()
    {
        return $this->_controller;
    }
    /*
     * get_action()
     * @note : permet de retourner l'action
     * @return : string
     */
    public function get_action()
    {
        return $this->_action;
    }
    /*
     * set_controller( $controller )
     * @note : permet d'initialiser le controleur
     * @return : void
     */
    public function set_controller( $controller )
    {
        $this->_controller = $controller;
    }
    /*
     * set_action( $action )
     * @note : permet d'initialiser l'action
     * @return : void
     */
    public function set_action( $action )
    {
        $this->_action = $action;
    }

    /*
     * getPdo()
     * @note : permet de retourner un objet PDO
     * @return : PDO Object
     */
    public function get_pdo()
    {
        return $this->_pdo;
    }

    /*
     * set_pdo( $host , $user , $pass , $base )
     * @note : permet d'instancer un objet PDO
     * @return : void
     */
    public function set_pdo( $host , $user , $pass , $base )
    {
      // Exception si les parametres n'existent pas
      if( !( isset( $host ) || isset( $user ) || isset( $pass ) || isset( $base ) ) )
      {
        throw new Exception ( 'Echec de chargement des variables de config' );
      }

      $this->_pdo = new PDO( "mysql:host=" . $host . ";dbname=" . $base , $user, $pass );
      $this->_pdo->query("SET NAMES 'utf8'");
    }

    /*
     * route()
     * @note : permet d'appeler le controleur avec les paramètres fournis
     * @return : void
     */
    public function route()
    {

        try
        {

            $stdclass = '';     // Classe appelée
            $args = array();    // Arguments passés

            //$this->_controller  = !empty( $_GET[NAME_CONTROLLER] )  ? $_GET[NAME_CONTROLLER]: DEFAULT_CONTROLLER;
        //$this->_action    = !empty( $_GET[NAME_ACTION] )      ? $_GET[NAME_ACTION]    : DEFAULT_ACTION;

        if( is_file( DIR_CONTROLLERS.$this->_controller.EXT_CONTROLLER ) )
        {

          require_once( DIR_CONTROLLERS.$this->_controller.EXT_CONTROLLER );

            // Est-ce que la classe existe ?
            if( $rc = new ReflectionClass( $this->_controller.'_controller' ) )
            {

              // On instancie la classe appelée
              $stdclass = $rc->newInstance();

              // Est-ce que la méthode appelée existe ?
              if( $rc->hasMethod( $this->_action ) )
              {

                // On récupère la liste des paramètres
                $rm = $rc->getMethod( $this->_action );
                $rp = $rm->getParameters();

                foreach( $rp as $parameter )
                {

                  // Existe-t-il un paramètre passé en GET ou POST correspondant ?
                  if( empty( $_REQUEST[ $parameter->getName() ] ) && !$parameter->isDefaultValueAvailable() )
                  {
                    throw new Exception( utf8_encode('Manque le param&egrave;tre : '.$parameter->getName()),503 );
                  }
                  elseif (empty( $_REQUEST[ $parameter->getName() ] ) && $parameter->isDefaultValueAvailable() )
                  {
                    // On alimente le tableau des paramètres
                    $args[ $parameter->getName() ] = $parameter->getDefaultValue();
                  }
                  else
                  {
                    // On alimente le tableau des paramètres
                    $args[ $parameter->getName() ] = $_REQUEST[ $parameter->getName() ];
                  }

                }


                // On appelle la méthode
                $rm->invokeArgs( $stdclass , $args );

              }
              else
              {
                throw new Exception(utf8_encode('Cette m&eacute;thode n\'existe pas.'),502);
              }

            }
                else
                {
                    throw new Exception( utf8_encode('Cette classe n\'existe pas.'),501);
                }

            }
            else
            {
                throw new Exception( utf8_encode("Le fichier ".DIR_CONTROLLERS.$this->_controller.EXT_CONTROLLER." n'existe pas.") , 500);
            }

        }
        catch( Exception $e )
        {
            // if exception is an instance of ReflectionException
            // then error comes from router
            // so we can explicitly define a status code

            if( $e instanceof ReflectionException )
                throw new Exception( utf8_encode("Router error"),400);
            else
                throw $e;

            // debug
            /*echo "<pre>";
            var_dump(["ReflectionException?"=>$e instanceof ReflectionException]);
            var_dump($e);
            echo "</pre>";*/
        }

  }

}
?>
