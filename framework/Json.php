<?php

class Json extends View
{
	protected $status;
	protected $body; // hérité de View
	protected $content_type;
	
	public function __construct()
	{
		$this->content_type = 'application/json';
	}
	
	public function render()
	{
		$this->body = json_encode( $this->body );
		parent::render();
	}
	
}

?>