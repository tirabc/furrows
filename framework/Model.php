<?php

/**
 * Model
 *
 * @author christian barras <tirabc@gmail.com>
 */
class Model
{
	/**
	 * @note: Par convention, tous les attributs sont déclarés dans la classe fille
	 *        les attributs commencant par '__' concernent le nom de la table
	 *        ou de la classe. (ex: __table)
	 */

	 public function getNewInstance($args = [])
	 {
		 $refl = new ReflectionClass($this->__name);
		 $instance = $refl->newInstance();
		 $instance->setAttributes($args);
		 return $instance;
	 }

	 public function getORM()
	 {
		 return ORM::for_table($this->__table);
	 }

  public function findAll()
  {
		$objects = array();
		$models = $this->getORM()
		  ->find_many();
		foreach($models as $model)
		{
			$instance = $this->getNewInstance($model->as_array());
			array_push($objects,$instance);
		}
		return $objects;
  }

	public function findById($id)
	{
		$model = $this->getORM()
	    ->find_one($id);
		$instance = $this->getNewInstance($model->as_array());
		return $instance;
	}

	public function findOneBy($column,$value)
	{
		$model = $this->getORM()
			->where($column,$value)
			->find_one();
		$instance = $this->getNewInstance($model->as_array());
		return $instance;
	}

	// $where Array
	public function findAllBy($where)
	{
		$objects = array();
		$models = $this->getORM()
		  ->where($where)
		  ->find_many();
		foreach($models as $model)
		{
			$instance = $this->getNewInstance($model->as_array());
			array_push($objects,$instance);
		}
		return $objects;
	}

	// $where_raw String
	public function findAllByRaw($where_raw)
	{
		$objects = array();
		$models = $this->getORM()
		  ->where_raw($where_raw)
		  ->find_many();
		foreach($models as $model)
		{
			$instance = $this->getNewInstance($model->as_array());
			array_push($objects,$instance);
		}
		return $objects;
	}

	public function add()
	{
		$model = $this->getORM()->create();
		foreach ( $this as $column => $value )
		{
			if ( strpos ( $column , '__' ) !== false || $column === 'id' ) continue;
			$model->{$column} = $value;
		}
		$model->save();
		$instance = $this->getNewInstance($model->as_array());
		return $instance;
	}

	public function edit($array)
	{
		$this->set($array);
		$this->save();
		$instance = $this->getNewInstance($model->as_array());
		return $instance;
	}

	public function delete($id = null)
	{
		if($id)
			$this->getORM()->find_one($id)->delete();
		else
			$this->delete();
	}

  public function setAttributes( $mixed )
  {
    if( !is_object( $mixed ) && !is_array( $mixed ) )
    {
      throw new Exception( "Not an object or an array" );
    }
    foreach( $mixed as $key => $value )
    {
      $this->{$key} = $value;
    }
  }

	public function __set($att, $val)
	{
		$this->$att = $val;
	}

	public function __get($att)
	{
		return $this->$att;
	}

}
?>
