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
    
    /*
     * load_view($view, $data)
     */
    public function load_view($view, $data=null)
    {
    	// TODO: check if $data is an array
		if(isset($data))
		{
			foreach($data as $key => $value)
			{
				${$key} = $value;
			}
		}

		require_once(DIR_VIEWS.$view.EXT_VIEW);
	}
	


}
?>
