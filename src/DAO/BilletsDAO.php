<?php
namespace projet3\DAO;
use projet3\Domain\Billets;
class BilletsDAO extends DAO
{
    /**
     * Return a list of all articles, sorted by date (most recent first).
     *
     * @return array A list of all articles.
     */
    public function findAll() {
        $sql = "select * from t_billets order by bil_id desc";
        $result = $this->getDb()->fetchAll($sql);
        // Convert query result to an array of domain objects
        $billets = array();
        foreach ($result as $row) {
            $billetsId = $row['bil_id'];
            $billets[$billetsId] = $this->buildDomainObject($row);
        }
        return $billets;
    }
    /**
     * Returns an article matching the supplied id.
     *
     * @param integer $id The article id.
     *
     * @return \MicroCMS\Domain\Article|throws an exception if no matching article is found
     */
    public function find($id) {
        $sql = "select * from t_billets where bil_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No article matching id " . $id);
    }
    /**
     * Saves an article into the database.
     *
     * @param \MicroCMS\Domain\Article $article The article to save
     */
    public function save(Billets $billets) {
        $billetsData = array(
            'bil_title' => $billets->getTitle(),
            'bil_content' => $billets->getContent(),
            );
        if ($billets->getId()) {
            // The article has already been saved : update it
            $this->getDb()->update('t_billets', $billetsData, array('bil_id' => $billets->getId()));
        } else {
            // The article has never been saved : insert it
            $this->getDb()->insert('t_billets', $billetsData);
            // Get the id of the newly created article and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $billets->setId($id);
        }
    }
    /**
     * Removes an article from the database.
     *
     * @param integer $id The article id.
     */
    public function delete($id) {
        // Delete the article
        $this->getDb()->delete('t_billets', array('bil_id' => $id));
    }
    /**
     * Creates an Billets object based on a DB row.
     *
     * @param array $row The DB row containing Article data.
     * @return \projet3\Domain\Billets
     */
    protected function buildDomainObject(array $row) {
        $billets = new Billets();
        $billets->setId($row['bil_id']);
        $billets->setTitle($row['bil_title']);
        $billets->setContent($row['bil_content']);
        return $billets;
    }
}