<?php

class Error
{
	private $codes = array(
		401 => "Mon erreur",
		402 => "nkdjzhndjkeznd"
	);
	
	public function getMessage( $code )
	{
		return $this->codes[ $code ];
	}
	
}

?>