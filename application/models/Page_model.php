<?php

class Page extends Model
{

    protected $__table = 'pages';
    protected $__name = 'Page';
    protected $id;
    protected $title;
    protected $content;
    protected $register_date;
        
    public function toArray()
    {
        return array(
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "register_date" => $this->register_date
        );
    }
    
}

?>
