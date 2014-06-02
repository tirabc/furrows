<?php

class Mustache extends View implements iRenderView
{
	public $engine;
	public $template;
	public $data;

	public function __construct( $template , $data )
	{
		
		$this->engine = new Mustache_Engine(array(
			//'template_class_prefix' => '__MyTemplates_',
			//'cache' => dirname(__FILE__).'/tmp/cache/mustache',
			'loader' => new Mustache_Loader_FilesystemLoader(DIR_VIEWS),
			'partials_loader' => new Mustache_Loader_FilesystemLoader(DIR_VIEWS."/common"),
			//'helpers' => array('i18n' => function($text) {
				// do something translatey here...
			//}),
			'escape' => function($value) {
				return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
			},
			'charset' => 'ISO-8859-1'
		));
		
		$this->template = $template;
		$this->data = $data;
		
	}
	
	public function render()
	{
		$this->body = $this->engine->render( $this->template , $this->data );
		parent::render();
	}
    
    public function render_without_header()
    {
        $this->body = $this->engine->render( $this->template , $this->data );
    }
	
}

?>