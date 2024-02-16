<?php

class Produit{
    private ?int $ID;
    private ?String $Nom;
    private ?int $Prix;
    private ?String $Description;
    private ?String $Photo;

    public function __construct(?int $ID){
        $this->ID = $ID;
    }
    

    /**
     * Get the value of ID
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    /**
     * Set the value of ID
     */
    public function setID(?int $ID): self
    {
        $this->ID = $ID;

        return $this;
    }

    /**
     * Get the value of Nom
     */
    public function getNom(): ?String
    {
        return $this->Nom;
    }

    /**
     * Set the value of Nom
     */
    public function setNom(?String $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * Get the value of Prix
     */
    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    /**
     * Set the value of Prix
     */
    public function setPrix(?int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    /**
     * Get the value of Description
     */
    public function getDescription(): ?String
    {
        return $this->Description;
    }

    /**
     * Set the value of Description
     */
    public function setDescription(?String $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * Get the value of Photo
     */
    public function getPhoto(): ?String
    {
        return $this->Photo;
    }

    /**
     * Set the value of Photo
     */
    public function setPhoto(?String $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }
}