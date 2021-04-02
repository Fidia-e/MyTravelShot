<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


// class de mon entité `Shot` étendue du CoreModel
class Shot extends CoreModel {

    // Je déclare mes propriétés
    protected $title;
    protected $picture;
    protected $description;
    protected $publication_date;
    protected $author_id;

    /**
     * Methode me permettant de récuperer toutes les photos
     *
     * @return array Shot[] // je vais récupérer un tableau d'objets
     */
    public static function findAll()
    {
        // je me connecte ma BDD grâce
        // en récupérant l'instance PDO
        $pdo = Database::getPDO();

        // je déclare ma requête
        $sql = 'SELECT * FROM shot';


        // je récupère une instance de la class pdoStatement
        // je lui donne ma requête
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();

        // je retourne le résultat de ma requête sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }


    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @return  self
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of publication_date
     */ 
    public function getPublicationDate()
    {
        return $this->publication_date;
    }


    /**
     * Get the value of author_id
     */ 
    public function getAuthorId()
    {
        return $this->author_id;
    }
}

