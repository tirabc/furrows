<?php

class Post extends Model
{

    protected $__table = 'posts';
    protected $__name = 'Post';
    protected $id;
    protected $title;
    protected $content;
    protected $register_date;

    public function say_hello()
    {
      echo "hello";
    }

}

?>
