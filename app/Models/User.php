<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


// class de mon entité `User` 
// étendue du CoreModel
class User extends CoreModel {

    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $city;
    private $country;
    private $role;


    /**
     * Methode me permettant de récuperer tous les utilisateurs
     *
     * @return array User[] // je vais récupérer un tableau d'objets
     */
    public static function findAll()
    {
        // je me connecte ma BDD 
        // en récupérant l'instance PDO
        $pdo = Database::getPDO();

        // je déclare ma requête
        $sql = 'SELECT * FROM user';


        // je récupère une instance de la class pdoStatement
        // je lui donne ma requête
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute();

        // je retourne le résultat de ma requête sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }


    /**
     * Méthode permettant de trouver un utilisateur par son email
     * 
     * @return User // je vais récupérer un objet de mon instrance User
     */
    public static function findByEmail($email)
    {
        // Récupération de PDO
        $pdo = Database::getPDO();

        // Écriture de la requête SQL
        $sql = "SELECT * 
                FROM `user`
                WHERE `email` = :email
                ";
        
        // je prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacement du paramètre email par sa vraie valeur
        $pdoStatement->bindValue(':email', $email);

        // exécution de la requête
        $pdoStatement->execute();

        // récupération du résultat sous forme d'objet
        $result = $pdoStatement->fetchObject(self::class);

        // je retourne l'utilisateur trouvé
        return $result;
    }


    /**
     * Méthode permettant d'ajouter un utilisateur à la BDD
     *
     */
    public function insert()
    {
       
        // appel de notre interprète SQL : PDO
        $pdo = Database::getPDO();

        // je définie ma requête avec des tokens/mots remplaçant mes valeurs
        // j'indique ainsi à MySQL à quoi doit ressembler la requête peu importe les valeurs
        // c'est ce qu'on appelle des requêtes préparées
        $sql = "INSERT INTO user (
            `firstname`, 
            `lastname`, 
            `email`, 
            `password`, 
            `city`, 
            `country`, 
            `role`
            ) 
        VALUES (
            :firstname, 
            :lastname, 
            :email, 
            :password, 
            :city, 
            :country, 
            :role
            )";

        // je prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // on remplace les 'tokens' par leur vraie valeur
        // on peut ajouter une seconde sécurité pour forcer le type de la donnée (bindValue)
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':city', $this->city, PDO::PARAM_STR);
        $pdoStatement->bindValue(':country', $this->country, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);

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

    public function update(){
        
        // TODO
    }

    public static function find($id){

        // TODO
    }



    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

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
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}