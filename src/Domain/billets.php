<?php

namespace projet3\Domain\billets;

class billets 
{
    /**
     * Article id.
     *
     * @var integer
     */
    private $id;

    /**
     * Article title.
     *
     * @var string
     */
    private $titre;

    /**
     * Article content.
     *
     * @var string
     */
    private $contenu;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($title) {
        $this->titre = $titre;
        return $this;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function setContenu($content) {
        $this->contenu = $contenu;
        return $this;
    }
}