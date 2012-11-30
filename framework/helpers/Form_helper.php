<?php

class Form
{
	private $errors = array();

	public function check_errors($array)
	{
		foreach($array as $var => $val)
		{
			if(!isset($_REQUEST[$val]))
			{
				$this->errors[$var] = $val;
			}
		}
	}
	
	public function __get($att)
	{
		return $this->$att;
	}
	
	public function is_valid()
	{
		return is_null($this->errors);
	}
	
	public function get_values()
	{
		return $_REQUEST;
	}

}

?>
