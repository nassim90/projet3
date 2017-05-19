<?php

namespace projet3\DAO;

use Doctrine\DBAL\Connection;

abstract class DAO 
{
    /**
     * connection a la base de donnée
     
     */
    private $db;

   
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Grants access to the database connection object
     *
     * @return \Doctrine\DBAL\Connection The database connection object
     */
    protected function getDb() {
        return $this->db;
    }

    /**
     * Builds a domain object from a DB row.
     * Must be overridden by child classes.
     */
    protected abstract function buildDomainObject(array $row);
}