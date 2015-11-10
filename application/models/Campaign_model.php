<?php

class Campaign extends Model
{

    protected $__table = 'campaigns';
    protected $__name = 'Campaign';
    public $id;
    public $uid;
    public $name;
    public $description;
    public $date;
        
    public function toArray()
    {
        return array(
            "id" => $this->id,
            "uid" => $this->uid,
            "name" => $this->name,
            "description" => $this->description,
            "date" => $this->date
        );
    }
    
}

?>
