<?php

class User
{
	private $table = 'user';
	private $id;
	private $username;
	private $password;
	private $level_id;
	private $date_created;
		
	/*******************************************************************
	 * 
	 * get_user_by_id($id)
	 * 
	 ******************************************************************/	

	public function get_user_by_id($id)
	{
		global $pdo;
		
		$sql = 'SELECT * FROM '.$this->table.' WHERE id='.$id;
		$query = $pdo->query( $sql );
		$results = $query->fetch();
		
		return $results;
	}
	
	/*******************************************************************
	 * 
	 * add()
	 * 
	 ******************************************************************/	

	public function add()
	{
		global $pdo;
		
		$sql = 'INSERT INTO '.$this->table.' VALUES(	"" ,
														"'.$this->username.'",
														"'.$this->password.'",
														"'.$this->email.'",
														"'.$this->level_id.'",
														"'.$this->date_created.'"	)';echo $sql;
		$query = $pdo->query($sql);
	}
	
	/*******************************************************************
	 * 
	 * edit($id)
	 * 
	 ******************************************************************/
	
	public function edit($id)
	{
		global $pdo;
		
		$sql = 'UPDATE '.TABLE_USERS.' 	SET username="'.$this->username.'",
											password="'.$this->password.'",
											level_id='.$this->level_id.',
											date_created='.$this->date_created.'
										WHERE id='.$id;
		$query = $pdo->query( $sql );
		
		if(!$query)
		{
			throw new Exception('Erreur edit');
		}
	}
	
	/*******************************************************************
	 * 
	 * __set($att, $val)
	 * 
	 ******************************************************************/	

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
		
	/*******************************************************************
	 * 
	 * connect()
	 * 
	 ******************************************************************/	

	public function connect()
	{
		if(empty($this->username))
		{
			throw new Exception('Username vide !');
		}
		
		if(empty( $this->password ) )
		{
			throw new Exception('Password vide !');
		}
		
		global $pdo;
		
		$sql = 'SELECT * FROM '.$this->table.' WHERE username="'.$this->username.'"
												AND password="'.$this->password.'"';
		$query = $pdo->query($sql);
		
		return $results = $query->fetch();		
	}
	
	/*******************************************************************
	 * 
	 * check_level($level)
	 * 
	 ******************************************************************/
	
	public static function check_level($level)
	{
		if(!(isset($_SESSION[SESSION]) && $_SESSION[SESSION] === $level))
		{
			throw new Exception( 'Level '.$level.' requis !' );
			//header( 'Location: index.php' );
		}
	}

}

?>
