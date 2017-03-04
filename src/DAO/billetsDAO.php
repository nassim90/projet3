<?php

namespace projet3\DAO;

use Doctrine\DBAL\Connection;
use projet3\Domain\billets;

class billetsDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "select * from billets order by id desc";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $billets = array();
        foreach ($result as $row) {
            $billetsId = $row['id'];
            $billets[$billetsId] = $this->buildBillets($row);
        }
        return $billets;
    }

    /**
     * Creates an billets object based on a DB row.
     *
     * @param array $row The DB row containing billets data.
     * @return \projet3\Domain\billets
     */
    private function buildBillets(array $row) {
        $billets = new billets();
        $billets->setId($row['id']);
        $billets->setTitre($row['titre']);
        $billets->setContenu($row['contenu']);
        return $billets;
    }
}