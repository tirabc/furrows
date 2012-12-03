<?php

/**
 * Model
 *
 * @author christian barras
 */
class Model
{
	/**
	 * @note: Par convention, tous les attributs sont déclarés dans la classe fille
	 *        les attributs commencant par '__' concernent le nom de la table
	 *        ou de la classe. (ex: __table)
	 */

	/**
     * find_all()
     * @note : récupère tous les enregistrements de la table
     * @return : array of User objects
     */
    public function find_all()
    {
		global $pdo;

		$sql = 'SELECT * FROM ' . $this->__table;
		$query = $pdo->query ( $sql );
		$array = $query->fetchAll();
		/*$array = array();
		while ( $object = $query->fetchObject ( $this->__name ) ) 
		{
			array_push ( $array , $object );
		}*/
		return $array;
    }
    
    /**
     * find_by_id($id)
     * @note : récupère l'enregistrement identifié par $id
     * @return : User object
     */	

	public function find_by_id($id)
	{
		global $pdo;
		
		$sql = 'SELECT * FROM ' . $this->__table . ' WHERE id=' . $id;
		$query = $pdo->query ( $sql );
		$object = $query->fetchObject ( $this->__name );
		
		return $object;
	}
	
	/**
     * find_all_by($column,$value)
     * @note : récupère tous les enregistrements respectant la condition passée en paramètre
     * @return : array Object StdClass
     */	
	public function find_all_by($column,$value)
	{
		global $pdo;

		$sql = 'SELECT * FROM ' . $this->__table . ' WHERE ' . $column . '=' . $value ;
		$query = $pdo->query ( $sql );
		$array = $query->fetchAll(PDO::FETCH_CLASS);
		
		return $array;
	}
	
	/**
     * add()
     * @note : Permet d'ajouter un enregistrement dans la table
     * @return : void
     */
     
	public function add()
	{
		global $pdo;
		
		$values = array();
		$columns = array();
		
		foreach ( $this as $column => $value ){
			if ( strpos ( $column , '__' ) !== false || $column === 'id' ) continue;
			$values[] = $pdo->quote ( $value );
			$columns[] = $column;
		}
		
		$statement_columns = implode ( ',' , $columns );
		$statement_values = implode ( ',' , $values );
		
		$sql = 'INSERT INTO ' . $this->__table . ' (' . $statement_columns . ') ';
		$sql .= 'VALUES (' . $statement_values . ')';
		
		$query = $pdo->query ( $sql );
		
		if( !$query )
		{
			throw new Exception ( 'Erreur insert' );
		}
	}

	/**
     * edit($id)
     * @note : Permet de modifier l'enregistrement identifié par $id
     * @return : void
     */
     
	public function edit($id)
	{
		global $pdo;
		
		$this->id = $id;
		$properties = array();
		
		foreach ( $this as $column => $value ){
			if ( strpos ( $column , '__' ) !== false ) continue;
			$properties[ $column ] = $column . '=' . $pdo->quote ( $value );
		}
		
		$statement = implode ( ',' , $properties );
		
		$sql = 'UPDATE ' . $this->__table . ' SET ' . $statement . ' WHERE id=' . $this->id;
		$query = $pdo->query ( $sql );
		
		if( !$query )
		{
			throw new Exception( 'Erreur edit' );
		}
	}

	/**
     * delete($id)
     * @note : Permet de supprimer un enregistrement
     * @return : void
     */
	public function delete($id)
	{
		global $pdo;
		
		$this->id = $id;
		
		$sql = 'DELETE FROM ' . $this->__table . ' WHERE id=' . $this->id;
		$query = $pdo->query ( $sql );
		
		if( !$query )
		{
			throw new Exception( 'Erreur delete' );
		}
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
