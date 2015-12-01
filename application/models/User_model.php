<?php

class User extends Model
{

    protected $__table = 'users';
    protected $__name = 'User';
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $register_date;

    public function toArray()
    {
        return array(
            "id" => $this->id,
            "email" => $this->email,
            "name" => $this->name,
        );
    }

}

?>
