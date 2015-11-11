<?php

/**
 * Controller
 *
 * @author christian barras
 */
class Controller
{
	protected $models = array();
	protected $helpers = array();
	
    /*
     * __construct()
     * @note : instancie un controleur
     * @return : void
     */
    public function __construct()
    {
    	$this->load_models();
        $this->load_helpers();
        // sessions
        session_start();

        if( method_exists( $this , "before" ) )
            $this->before();
    }

    /*
     * load_models()
     * @note : permet de charger les modèles nécessaires pour le controleur
     * @return : void
     */
    public function load_models()
    {
        foreach($this->models as $model)
		{
			require_once(DIR_MODELS.$model.EXT_MODEL);
		}
    }
    
    /*
     * load_helpers()
     * @note : permet de charger les helpers nécessaires pour le controleur
     * @return : void
     */
    public function load_helpers()
    {
        foreach($this->helpers as $helper)
		{
            require_once(DIR_HELPERS.$helper.EXT_HELPER);
		}
    }
	
}
?>
