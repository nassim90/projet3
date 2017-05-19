<?php
namespace projet3\Domain;

class Comment 
{
   
    private $id;
    
    private $author;
    
    private $content;
   
    private $billets;
    
    private $parent;
    
    private $bad;
    
    private $subcomments;
    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getAuthor() {
        return $this->author;
    }
    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }
    public function getContent() {
        return $this->content;
    }
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    public function getBillets() {
        return $this->billets;
    }
    public function setBillets(Billets $billets) {
        $this->billets = $billets;
        return $this;
    }
    public function getParent() {
        return $this->parent;
    }
    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }
    public function getBad() {
        return $this->bad;
    }
    public function setBad($bad) {
        $this->bad = $bad;
        return $this;
    }
    public function getSubcomments() {
        return $this->subcomments;
    }
    public function setSubcomments($subcomments) {
        $this->subcomments = $subcomments;
        return $this;
    }
}