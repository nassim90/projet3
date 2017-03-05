<?php

namespace projet3\DAO;

use projet3\Domain\billets;

class billetsDAO extends DAO
{
    /**
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */

    public function find($id) {
        $sql = "select * from billets where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No billets matching id " . $id);
    }

    public function findAll() {
        $sql = "select * from billets order by id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $billets = array();
        foreach ($result as $row) {
            $billetsId = $row['id'];
            $billets[$billetsId] = $this->buildDomainObject($row);
        }
        return $billets;
    }

    /**
     * Creates an Article object based on a DB row.
     *
     * @param array $row The DB row containing Article data.
     * @return \MicroCMS\Domain\Article
     */
    protected function buildDomainObject(array $row) {
        $billets = new billets();
        $billets->setId($row['id']);
        $billets->setTitre($row['titre']);
        $billets->setContenu($row['contenu']);
        return $billets;
    }
}