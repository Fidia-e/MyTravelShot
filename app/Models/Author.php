<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


// class de mon entité `Author` 
// étendue du CoreModel
class Author extends CoreModel {

    private $username;
    private $city;
    private $country;
    private $user_id;

    /**
     * Methode me permettant de récuperer tous les auteurs
     *
     * @return array Author[] // je vais récupérer un tableau d'objets
     */
    public static function findAll()
    {
        // je me connecte ma BDD grâce
        // en récupérant l'instance PDO
        $pdo = Database::getPDO();

        // je déclare ma requête
        $sql = 'SELECT * FROM `author`';


        // je récupère une instance de la class pdoStatement
        // je lui donne ma requête
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();

        // je retourne le résultat de ma requête sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }


    /**
     * Méthode permettant de récupérer un auteur avec son id
     * 
     * @param int $authorId ID de l'auteur
     * @return Author
     */
    public static function find($authorId)
    {
        // connexion à la BDD
        $pdo = Database::getPDO();

        // déclaration de la requête
        $sql = 'SELECT * FROM `author` WHERE `id` =' . $authorId;

        // je récupère une instance de la class pdoStatement
        // je lui donne ma requête
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();

        // un seul résultat sous forme d'objet => fetchObject
        $result = $pdoStatement->fetchObject('App\Models\Author');

        // retourner le résultat
        return $result;
    }

    public function insert()
    {

        // TODO
    }

    public function update()
    {

        // TODO
    }



    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }
}