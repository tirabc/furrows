<?php

/**
 * View
 *
 * @author christian barras
 */
class View
{
    protected $body;
    protected $status = '200';
    protected $message = 'Ok';

    /*
     * render()
     * @note : afficher la vue
     * @return : void
     */
    public function render()
    {
    	$status_header = 'HTTP/1.1 ' . $this->status . ' ' . $this->message;  
    	header($status_header);
        echo $this->body;
    }

    /*
     * get_body()
     * @note : retourne le contenu du template
     * @return : string
     */
    public function get_body()
    {
        return $this->body;
    }
    
    /**
     * __set($att,$val)
     * @note : Permet d'initialiser un attribut
     * @return : void
     */
	public function __set($att, $val)
	{
		$this->$att = $val;
	}
	
	/**
     * __get($att)
     * @note : Permet de récupérer un attribut
     * @return : mixed
     */

	public function __get($att)
	{
		return $this->$att;
	}

}
?>
