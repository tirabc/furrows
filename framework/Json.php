<?php

class Json extends View implements iRenderView
{
	protected $status; // hérité de View
	protected $body; // hérité de View
	protected $content_type;
	
	public function __construct()
	{
		$this->content_type = 'application/json';
	}
	
	public function render( $status = 200 )
	{
		$this->status = $status;
		$this->body = json_encode( $this->body );
		parent::render();
	}
	
}

?>