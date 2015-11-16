<?php

class Error
{
	private $codes = array(
		401 => "Mon erreur",
		402 => "nkdjzhndjkeznd"
	);

	public function __construct()
	{
		$array = parse_ini_file( "errors.ini" );
		$this->codes = $array;
	}
	
	public function getMessage( $code )
	{
		return $this->codes[ $code ];
	}

	static function throw ( $code , $msg = null )
	{
		// TODO: retourner un code en plus du message (array) ?
		return empty($msg) ? $this->getMessage( $code ) : $msg;
	}

	Error::throw( 404 );
	Error::throw( 404 , "mon msg perso" );
	
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