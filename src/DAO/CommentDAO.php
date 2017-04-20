<?php
namespace blog\DAO;
use blog\Domain\Comment;
class CommentDAO extends DAO 
{
    
    private $billetsDAO;
    
    
    public function setBilletsDAO(BilletsDAO $billetsDAO) {
        $this->billetsDAO = $billetsDAO;
    }
   
    
    public function findAll() {
        $sql = "select * from t_comment order by com_id desc";
        $result = $this->getDb()->fetchAll($sql);
        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
    
    public function findAllByBillets($billetsId) {
    
        // art_id is not selected by the SQL query
    
        // The article won't be retrieved during domain objet construction
        $sql = "select com_id,com_author,com_content from t_comment where bil_id=? and parent_id is null order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($billetsId));
        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
           
            $comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            
            $comments[$comId] = $comment;
        }
        return $comments;
            
    }
    
    public function findAllByParentId($parentId){
        
        $sql = "select com_id, com_author, com_content, parent_id from t_comment where parent_id =? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($parentId));
        $subcomments = array();
        foreach ($result as $row) {
            $parentId = $row['parent_id'];
            $subcomment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            // $comment->setBillets($billets);
            $subcomments[] = $subcomment;
        }
        return $subcomments;
    }
    
   
    public function find($id) {
        $sql = "select * from t_comment where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No comment matching id " . $id);
    }
   
    public function save(Comment $comment) {
        $commentData = array(
            'bil_id' => $comment->getBillets()->getId(),
            'com_author' => $comment->getAuthor(),
            'parent_id' => $comment->getParent(),
            'com_content' => $comment->getContent()
            );
        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDb()->update('t_comment', $commentData, array('com_id' => $comment->getId()));
        } else {
            // The comment has never been saved : insert it
            $this->getDb()->insert('t_comment', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }
    
    
    public function deleteAllByBillets($billetsId) {
        $this->getDb()->delete('t_comment', array('bil_id' => $billetsId));
    }
   
    
    
    public function delete($id) {
        
        $this->getDb()->delete('t_comment', array('com_id' => $id));
    }
    
    public function bad($bad){
    if ($bad==null)
	{
		return false;
	}
	else
	{
		return true;
	}
        
    }
    
    
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $subcomment = new Comment();
        $comment->setId($row['com_id']);
        $comment ->setAuthor($row['com_author']);
        $comment->setContent($row['com_content']);
        if (array_key_exists('bil_id', $row)) {
            // Find and set the associated article
            $billetsId = $row['bil_id'];
            $billets = $this->billetsDAO->find($billetsId);
            $comment->setBillets($billets);
        }
       $comment->setSubcomments($this->findAllByParentId($comment->getId()));
        
        return $comment;
    }
}