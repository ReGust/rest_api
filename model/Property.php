<?php

namespace Modal\Property;

use Exception;
use Modal\Entity\Entity;

class Property extends Entity
{
    const DB_TABLE = "table_property";

    protected $parent;
    public $name;

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent( $parent )
    {
        $this->parent = $parent;
    }

    public function save() {
        try {
            if ($this->getId()) {
                $sql = 'UPDATE %s SET name = :name AND parent = :parent WHERE id = :id';
                $params[':id'] = $this->getId();
            } else {
                $sql = 'INSERT INTO %s (name, parent) VALUES (:name, :parent)';
            }
            $params[':name'] = $this->name;
            $params[':parent'] = $this->getParent();
            $tables = array(Property::DB_TABLE);

            $properties = $this->db->squery($sql, $tables, $params);

            return $properties;
        } catch (Exception $e) {
            throw $e;
        }
    }
}