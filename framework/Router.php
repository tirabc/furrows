<?php

/**
 * Front_controller
 *
 * @author christian barras
 */
class Router
{

    private $_pdo;
    private $_controller;
    private $_action;
    private $_args;

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
    }
    
    /*
     * dispatch()
     * @note : permet de définir le controleur, l'action et les parametres de la requete
     * @prerequisite: htaccess + url/myresource/myid
     * @return : void
     */
    public function dispatch()
    {
        $data = explode('/',$_REQUEST['data']);
        
        // vars
        $_verb = strtolower( $_SERVER['REQUEST_METHOD'] );
        
        // Ressource
        if(!empty($data[0]))
        	$this->_controller = $data[0];
        
        // Action
        
        // CRUD
        switch($_verb){
            case 'put':
                $this->_action = 'update';
            break;
            case 'delete':
                $this->_action = 'delete';
            break;
            case 'get':
                $this->_action = 'retrieve';
            break;
            case 'post':
                $this->_action = 'create';
            break;
        }
        
        // Autre
        if( !empty( $_REQUEST['_action'] ) ){
        	$this->_action = $_REQUEST['_action'];
        }
        
		// Parametres
		$_args = $_REQUEST;
		if(!empty($data[1]))
			$_REQUEST['id'] = $data[1];
		$this->_args = $_args;
		        
    }

    public function dispatch_route()
    {
        $data = explode( '/' , $_REQUEST['data'] );
        $arr = array_reverse($data);
        $this->_controller = array_pop($arr);
        $this->_action = array_pop($arr);
        foreach ($arr as $cell) {
            $params = explode(':',$cell);
            $_REQUEST[$params[0]] = $params[1];
        }
        $this->_args = $_REQUEST;
    }

    /*
     * route()
     * @note : permet d'appeler le controleur avec les paramètres fournis
     * @return : void
     */
    public function route()
    {

        $stdclass = '';     // Classe appelée
        $args = array();    // Arguments passés

        $this->_controller	= !empty( $_GET[NAME_CONTROLLER] )	? $_GET[NAME_CONTROLLER]: DEFAULT_CONTROLLER;
		$this->_action		= !empty( $_GET[NAME_ACTION] )      ? $_GET[NAME_ACTION]    : DEFAULT_ACTION;

		$this->dispatch_route();

		if( is_file( DIR_CONTROLLERS.$this->_controller.EXT_CONTROLLER ) )
		{
			require_once( DIR_CONTROLLERS.$this->_controller.EXT_CONTROLLER );
		}
		
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
						throw new Exception( 'Manque le param&egrave;tre : '.$parameter->getName() );
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
				throw new Exception('Cette m&eacute;thode n\'existe pas.');
			}

		}
		
	}

}
?>
