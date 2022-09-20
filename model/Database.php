<?php

namespace Database;

use Exception;
use Modal\Property\Property;
use PDO;
use PDOException;

class Database
{
    protected static $instance;
    protected $pdo;

    public function __construct()
    {
        if( empty(self::$instance) ) {
            $this->connect();
        }
    }

    public static function getInstance() {

        if( empty(self::$instance) ) {
            (new Database)->connect();
        }

        return self::$instance;
    }

    public function squery( $query = "" ,$tables = [] , $params = [], $entity = 'stdClass' )
    {
        try {
            $sql = sprintf($query, implode(',', $tables));
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $entity);

            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }

    private function connect()
    {
        if( empty(self::$instance) ) {
            try {
                $dsn = "mysql:host=". DB_HOST .';dbname='. DB_DATABASE_NAME;
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                $this->pdo = new PDO($dsn , DB_USERNAME, DB_PASSWORD, $options);
                self::$instance = $this;
            } catch (PDOException $e) {
                throw new PDOException( $e->getMessage() );
            }
        }
    }


}