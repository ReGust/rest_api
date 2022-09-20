<?php

namespace Modal\Entity;

use Database\Database;

class Entity
{
    protected $db;
    protected $id;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function __get( $name ) {
        return call_user_func(array($this, 'get' . $name));
    }

    public function __set( $name, $value ) {
        call_user_func(array($this, 'set' . $name), $value);
    }

    public function getId()
    {
        return $this->id;
    }
}