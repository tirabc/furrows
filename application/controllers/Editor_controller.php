<?php

class Editor_controller extends Controller
{
	protected $models = array();
	
	/*******************************************************************
	 * 
	 * init()
	 * 
	 ******************************************************************/	
	
	public function init()
	{
		$this->load_view('editor/init');
	}
	
}

?>
