<?php

/**
 * Front_controller
 *
 * @author christian barras
 */
class Front_controller
{

    private $_pdo;
    private $_controller;
    private $_action;

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

		
		if( is_file( DIR_CONTROLLERS.$this->_controller.EXT_CONTROLLER ) )
		{
			require_once( DIR_CONTROLLERS.$this->_controller.EXT_CONTROLLER );
		}
		
		// Est-ce que la classe existe ?
		if( $rc = new ReflectionClass( $this->_controller.'_controller' ) )
		{
			
			// On instancie la classe appelée
			$stdclass = $rc->newInstance();

			// Est-ce que la méthode appelée existe ? --> Exception si non !!
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
