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
        // en récupérant l'instance PDO qui contient la connexion
        $pdo = Database::getPDO();

        // je déclare ma requête
        $sql = 'SELECT * FROM `author`';

        // je récupère une instance de la class pdoStatement
        // je lui donne ma requête
        $pdoStatement = $pdo->query($sql);

        // je retourne le résultat de ma requête sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        // je retourne le résultat
        return $results;
    }


    /**
     * Méthode permettant de récupérer un auteur avec son id
     * 
     * @param int $id ID de l'auteur
     * @return Author
     */
    public static function find($id)
    {
        // connexion à la BDD
        $pdo = Database::getPDO();

        // déclaration de la requête
        $sql = 'SELECT * 
                FROM `author` 
                WHERE `id` =' . $id;

        // je récupère une instance de la class pdoStatement
        // à qui je donne ma requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat sous forme d'objet => fetchObject
        $result = $pdoStatement->fetchObject(self::class);
        
        // retourner le résultat
        return $result;
    }

    /**
     * Méthode permettant de récupérer les informations 
     * de l'utilisateur associé à chaque auteur
     */
    public function getUserInformations()
    {
        // connexion à la BDD
        $pdo = Database::getPDO();

        // écriture de la requête préparée
        $sql = "SELECT 
                `firstname`,
                `lastname`
                FROM `user`
                WHERE `author_id` = :id";

        // je récupère une instance de la class pdoStatement
        // à qui je donne ma requête
        $pdoStatement = $pdo->prepare($sql);
        
        // remplacement du token :id par sa vraie valeur
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        // j'exécute la requête et stocke le résultat dans une variable
        $result = $pdoStatement->execute();
        
        // je récupère mon résultat
        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        // je retourne le résultat
        return $result;
    }

    /**
     * Méthode permettant d'ajouter un auteur à la BDD
     *
     */
    public function insert()
    {
        // appel de notre interprète SQL : PDO
        $pdo = Database::getPDO();

        // je définie ma requête avec des tokens/mots remplaçant mes valeurs
        // j'indique ainsi à MySQL à quoi doit ressembler la requête peu importe les valeurs
        // c'est ce qu'on appelle des requêtes préparées
        $sql = "INSERT INTO `author` (
            `username`, 
            `city`, 
            `country`, 
            `user_id`
            ) 
        VALUES (
            :username, 
            :city, 
            :country, 
            :user_id
            )";

        // je prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // on remplace les 'tokens' par leur vraie valeur
        // on peut ajouter une seconde sécurité pour forcer le type de la donnée (bindValue)
        $pdoStatement->bindValue(':username', $this->username, PDO::PARAM_STR);
        $pdoStatement->bindValue(':city', $this->city, PDO::PARAM_STR);
        $pdoStatement->bindValue(':country', $this->country, PDO::PARAM_STR);
        $pdoStatement->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);

        // j'exécute la requête
        $result = $pdoStatement->execute();

        // si ma requête fonctionne
        if($result) {
            // je mets à jour l'ID de mon objet avec le dernier ID inséré en BDD
            $this->id = $pdo->lastInsertId();
            
            $user = User::find($this->user_id);
            $user->setAuthorId($this->id);
            $user->save();
            
            // et retourne pour indiquer que la requête s'est bien passée
            return true;
        }

        // si le code arrive jusqu'ici, c'est que la requête ne s'est pas bien passée
        // on renvoie donc 'false'
        return false;
    }

    /**
     * Met à jour un auteur courant en BDD
     * 
     * @return bool $result
     */
    public function update()
    {
        // récupération de PDO
        $pdo = Database::getPDO();

        // création de la requête préparée
        $sql = "UPDATE `author`
                SET `username` = :username,
                `city` = :city,
                `country` = :country,
                `user_id` = :user_id,
                `updated_at` = NOW()
                WHERE id = :id ";

        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacement des tokens par leurs vraies valeurs
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':username', $this->username, PDO::PARAM_STR);
        $pdoStatement->bindValue(':city', $this->city, PDO::PARAM_STR);
        $pdoStatement->bindValue(':country', $this->country, PDO::PARAM_STR);
        $pdoStatement->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        
        // j'exécute la requête et je stocke le résultat dans une variable
        $result = $pdoStatement->execute();

        // je renvoie le résultat de la requête
        return $result;
    }

    /**
     * Supprime l'auteur de la BDD
     *
     * @return bool
     */
    public function delete()
    {
        // récupération de PDO
        $pdo = Database::getPDO();

        // création de la requête 
        $sql = "DELETE FROM `author`
                WHERE id = :id ";
  
        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacement des tokens par leurs vraies valeurs
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        // je exécute la requête et on stocke le résultat dans une variable
        $result = $pdoStatement->execute();

        // je renvoie le résultat de la requête
        return $result;
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