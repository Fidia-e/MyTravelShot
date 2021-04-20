<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


// class de mon entité `Shot` étendue du CoreModel
class Shot extends CoreModel {

    // je déclare mes propriétés
    private $title;
    private $picture;
    private $description;
    private $publication_date;
    private $author_id;

    /**
     * Methode me permettant de récuperer toutes les photos
     *
     * @return array Shot[] // je vais récupérer un tableau d'objets
     */
    public static function findAll()
    {
        // je me connecte ma BDD
        // en récupérant l'instance PDO
        $pdo = Database::getPDO();

        // je déclare ma requête
        $sql = 'SELECT * FROM `shot`';


        // je récupère une instance de la class pdoStatement
        // je lui donne ma requête
        $pdoStatement = $pdo->query($sql);

        // je retourne le résultat de ma requête sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }


    /**
     * Methode me permettant de récuperer toutes les photos en fonction de son auteur
     *
     * @return array Shot[] // je vais récupérer un tableau d'objets
     */
    public static function findByAuthorId($author_id)
    {
        // je me connecte ma BDD
        // en récupérant l'instance PDO
        $pdo = Database::getPDO();

        // je déclare ma requête
        $sql = 'SELECT *
                FROM `shot`
                WHERE `author_id` = :author_id';


        // je récupère une instance de la class pdoStatement
        // je lui donne ma requête
        $pdoStatement = $pdo->prepare($sql);

        // j'associe la valeur de :author_id à $author_id
        $pdoStatement->bindValue(':author_id', $author_id, PDO::PARAM_INT);

        // j'execute la requête
        $pdoStatement->execute();

        // je retourne le résultat de ma requête sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }


    /**
     * Méthode permettant de récupérer une publication par son id
     * 
     * @param int $id ID du shot
     * @return Shot
     */
    public static function find($id)
    {
        // connexion à la BDD
        $pdo = Database::getPDO();

        // déclaration de la requête
        $sql = 'SELECT * FROM `shot` WHERE `id` =' . $id;

        // je récupère une instance de la class pdoStatement
        // à qui je donne ma requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat sous forme d'objet => fetchObject
        $result = $pdoStatement->fetchObject(self::class);

        // je retourne le résultat
        return $result;
    }

    /**
     * Méthode permettant d'ajouter une publication à la BDD
     *
     */
    public function insert()
    {
       
        // appel de notre interprète SQL : PDO
        $pdo = Database::getPDO();

        // je définie ma requête avec des tokens/mots remplaçant mes valeurs
        // j'indique ainsi à MySQL à quoi doit ressembler la requête peu importe les valeurs
        // c'est ce qu'on appelle des requêtes préparées
        $sql = "INSERT INTO shot (
            `title`, 
            `picture`, 
            `description`, 
            `publication_date`,
            `author_id`
            ) 
        VALUES (
            :title, 
            :picture, 
            :description, 
            NOW(),
            :author_id
            )";

        // je prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // on remplace les 'tokens' par leur vraie valeur
        // on peut ajouter une seconde sécurité pour forcer le type de la donnée (bindValue)
        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':author_id', $this->author_id, PDO::PARAM_INT);

        // j'exécute la requête
        $result = $pdoStatement->execute();

        // si ma requête fonctionne
        if($result) {
            // je mets à jour l'ID de mon objet avec le dernier ID inséré en BDD
            $this->id = $pdo->lastInsertId();
            // et retourne pour indiquer que la requête s'est bien passée
            return true;
        }

        // si le code arrive jusqu'ici, c'est que la requête ne s'est pas bien passée
        // on renvoie donc 'false'
        return false;
    }

    /**
     * Met à jour un shot courant en BDD
     * 
     * @return bool $result
     */
    public function update()
    {
        // récupération de PDO
        $pdo = Database::getPDO();

        // création de la requête préparée
        $sql = "UPDATE `shot`
                SET `title` = :title,
                `picture` = :picture,
                `description` = :description,
                `author_id` = :author_id,
                `updated_at` = NOW()
                WHERE id = :id ";

        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacement des tokens par leurs vraies valeurs
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':author_id', $this->author_id, PDO::PARAM_INT);
        
        // j'exécute la requête et le stocke le résultat dans une variable
        $result = $pdoStatement->execute();

        // je renvoie le résultat de la requête
        return $result;
    }

    /**
     * Supprime le shot courant de la BDD
     *
     * @return bool
     */
    public function delete()
    {
        // récupération de PDO
        $pdo = Database::getPDO();

        // création de la requête 
        $sql = "DELETE FROM `shot`
                WHERE id = :id ";
  
        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacement des tokens par leurs vraies valeurs
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        // on exécute la requête et on stocke le résultat dans une variable
        $result = $pdoStatement->execute();

        // on renvoie le résultat de la requête
        return $result;
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

    /**
     * Set the value of author_id
     *
     * @return  self
     */ 
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;

        return $this;
    }
}


