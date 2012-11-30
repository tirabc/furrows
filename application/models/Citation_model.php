<?php

class Citation
{
	protected $table = 'citation';
	private $id;
	private $libelle;
	private $user_id;
	private $date;
	private $commentaire;
	private $vues;
	private $note;
	protected $columns = array();
	
	/*******************************************************************
	 * 
	 * get_citation_by_id($id)
	 * 
	 ******************************************************************/	

	public function get_citation_by_id()
	{
		global $pdo;
		
		$sql = 'SELECT * FROM '.$this->table.' WHERE id='.$this->id;
		$query = $pdo->query( $sql );
		$results = $query->fetchObject();
		$this->libelle=$results->libelle;
		$this->date=$results->date;
		$this->user_id=$results->user_id;
		$this->commentaire=$results->commentaire;
		$this->vues=$results->vues;
		$this->note=$results->note;
	}
	
	/*******************************************************************
	 * 
	 * add()
	 * 
	 ******************************************************************/	

	public function add()
	{
	/*connexion à la bd*/
	global $pdo;

	/*récuperer la tableau des champs de la table citation*/
	$tab_prop=_get_columns_by_propriety();	

	/*requete d'ajout d'une citation*/
	$sql = 'INSERT INTO '.$this->table.' (';	
	
$toto=1;	
	for($i=0; $i < count($tab_prop)-1; $i++)
	{
		$sql.= .$tab_prop[$i].',';
	}	
	$sql.= .$tab_prop[count($tab_prop)-1]')';
	
	/*executer la requette*/
	$query = $pdo->query($sql);
	
	echo $sql;
	}
	
	/*******************************************************************
	 * 
	 * delete($id)
	 * 
	 ******************************************************************/	

	public function delete_line()
	{
		global $pdo;
		
		$sql = 'DELETE FROM '.$this->table.' WHERE id='.$this->id;
		$query = $pdo->query($sql);
	}
		
	/*******************************************************************
	 * 
	 * edit($id)
	 * 
	 ******************************************************************/
	
	public function edit()
	{
		
		global $pdo;
		
		$sql = 'UPDATE '.$this->table.' SET libelle="'.$this->libelle.'",
												user_id='.$this->user_id.',
												date='.$this->date.',
												commentaire="'.$this->commentaire.'",
												vues='.$this->vues.',
												note='.$this->note.'
										WHERE id='.$this->id; echo($sql);
		$query = $pdo->query( $sql );
		
		if(!$query)
		{
			throw new Exception('Erreur edit');
		}
	}

	/*******************************************************************
	 * 
	 * _get_columns()
	 * 
	 ******************************************************************/
	 
	 public function _get_columns()
	 {		

		global $pdo;
		
		/*requete de récupération des des champs "colonnes" de la table citation de la bd*/
		$sql = 'SHOW COLUMNS FROM '.$this->table;

		/*test et récuperation de la requette dans la variable $result*/
		$result = $pdo->query( $sql);
		
		/*récupération des données dans un tableau $tab*/
		if($result->rowCount() > 0)
		{
			$tab = array();
			while($row = $result->fetchObject()) 
			{
				array_push ($tab,$row);
			}	
		}	

		/*retourn le tableau $tab*/
		return ($tab);	
		
	}

	/*******************************************************************
	 * 
	 * get_columns_by_propriety()
	 * values of columns citation table, in order : (Field, Type, Null, Key, Default, Extra)
	 * 
	 ******************************************************************/	
	 
	public function _get_columns_by_propriety($value="Field")
	
	{	
		/*initialisation de l'attibut columns*/
		$this->columns = $this->_get_columns();
		
		$tab=array();
		/*récuperer la propriete de chaque colonne*/
		for($i=0; $i < count($this->columns); $i++)
		{
			array_push($tab, $this->columns[$i]->$value);
		}
		/*retourner le tableau de la propriété de chaque colonne*/
		return($tab);	
	}

	
	public function __set($att, $val)
	{
		$this->$att = $val;
	}
	
	/*******************************************************************
	 * 
	 * __get($att)
	 * 
	 ******************************************************************/	

	public function __get($att)
	{
		return $this->$att;
	}

}

?>
