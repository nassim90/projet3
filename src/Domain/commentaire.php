<?php

namespace projet3\Domain;

class commentaire
{
    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Comment author.
     *
     * @var string
     */
    private $auteur;

    /**
     * Comment content.
     *
     * @var integer
     */
    private $commentaire;

    /**
     * Associated article.
     *
     * @var \MicroCMS\Domain\Article
     */
    private $article;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    public function setAuteur($auteur) {
        $this->auteur = $auteur;
        return $this;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getBillets() {
        return $this->billets;
    }

    public function setBillets(billets $billets) {
        $this->billets = $billets;
        return $this;
    }
}