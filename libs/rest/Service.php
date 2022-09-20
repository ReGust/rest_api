<?php

namespace libs\rest\Service;

use Database\Database;
use Exception;
use Modal\Property\Property;

class Service
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getPropertyByName( $name = null ) : Property
    {
        try {
            if (empty($name)) {
                throw new \Exception("No name given");
            }

            $sql = 'SELECT * FROM %s WHERE name = :name ORDER BY name ASC';
            $tables = array(Property::DB_TABLE);
            $params = array(':name' => $name);

            $property = $this->db->squery($sql, $tables, $params, Property::class);
            if (!$property) {
                throw new Exception('Property not found');
            }

            return reset($property);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getPropertyRelations( Property $property ) : array
    {
        try {
            $sql = 'SELECT * FROM %s WHERE parent = :id OR parent = :parent OR id = :parent2 ORDER BY name ASC';
            $tables = array(Property::DB_TABLE);
            $params = array(':id' => $property->getId(), ':parent' => $property->parent, ':parent2' => $property->parent);

            $properties = $this->db->squery($sql, $tables, $params, Property::class);
            $result = array();
            if (is_array($properties)) {
                foreach ($properties as $item) {
                    $outputItem = new \stdClass();
                    $outputItem->name = $item->name;
                    if ($item->parent == $property->parent) {
                        $outputItem->relation = 'sibling';
                    }
                    if ($item->parent == $property->id) {
                        $outputItem->relation = 'child';
                    }
                    if ($item->id == $property->parent) {
                        $outputItem->relation = 'parent';
                    }
                    $result[] = $outputItem;
                }
            }

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function add($name, $parent = null) : Property
    {
        try {
            $property = new Property();
            if ($parent) {
                $parent = $this->getPropertyByName($parent);
                $property->setParent($parent->getId());
            }

            $property->name = $name;
            $property->save();

            return $property;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllProperties() : array
    {
        try {
            $sql = 'SELECT * FROM %s ORDER BY name ASC';
            $tables = array(Property::DB_TABLE);
            $params = array();

            $property = $this->db->squery($sql, $tables, $params, Property::class);


            return $property;

        } catch (Exception $e) {
            throw $e;
        }
    }
}