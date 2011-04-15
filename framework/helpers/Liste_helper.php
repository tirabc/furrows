<?php

class Liste
{
	private $objet;
	private $quantite;
	private $contrainte;
	private $collection = array();

	public function __construct(){}
	
	public function create()
	{
		global $pdo;
		$sql = 'SELECT * FROM '.$this->objet;
		if($this->contrainte != null)
		{
			$sql .= ' ORDER BY '.$this->contrainte;
		}
		if($this->quantite != null)
		{
			$sql .= ' LIMIT 0,'.$this->quantite;
		}
		$query = $pdo->query($sql);
		while( $results = $query->fetch() )
		{
			$stdclass = new $this->objet();
			foreach($results as $att => $val)
			{
				$stdclass->__set($att,$val);
			}
			$this->collection[] = $stdclass;
		}
	}
	
	public function __get($att)
	{
		return $this->$att;
	}

	public function __set($att,$val)
	{
		$this->$att = $val;
	}

	
}

?>
