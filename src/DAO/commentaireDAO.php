<?php

namespace projet3\DAO;


use projet3\Domain\commentaire;

class commentaireDAO extends DAO 
{
    /**
     * @var \MicroCMS\DAO\ArticleDAO
     */
    private $billetsDAO;

    public function setBilletsDAO(billetsDAO $billetsDAO) {
        $this->billetsDAO = $billetsDAO;
    }

    /**
     * Return a list of all comments for an billets, sorted by date (most recent last).
     *
     * @param integer $articleId The billets id.
     *
     * @return array A list of all comments for the billets.
     */
    public function findAllByBillets($billetsId) {
        // The associated article is retrieved only once
        $billets = $this->billetsDAO->find($billetsId);

        // art_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "select id, auteur, commentaire from commentaires where post_id=? order by id";
        $result = $this->getDb()->fetchAll($sql, array($billetsId));

        // Convert query result to an array of domain objects
        $commentaires = array();
        foreach ($result as $row) {
            $comId = $row['id'];
            $commentaire = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $commentaire->setBillets($billets);
            $commentaires[$comId] = $commentaire;
        }
        return $commentaires;
    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \MicroCMS\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $commentaire = new  commentaire();
        $commentaire->setId($row['id']);
        $commentaire->setCommentaire($row['commentaire']);
        $commentaire->setAuteur($row['auteur']);

        if (array_key_exists('id', $row)) {
            // Find and set the associated article
            $billetsId = $row['id'];
            $billets = $this->billetsDAO->find($billetsId);
            $commentaire->setBillets($billets);
        }
        
        return $commentaire;
    }
}