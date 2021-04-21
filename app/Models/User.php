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
    private $role;
    private $author_id;


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
        $sql = 'SELECT * FROM `user`';

        // je récupère une instance de la class pdoStatement
        // et je lui donne ma requête
        $pdoStatement = $pdo->query($sql);

        // je retourne le résultat de ma requête sous forme de tableau d'objets
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }

    /**
     * Méthode permettant de récupérer un utilisateur avec son id
     * 
     * @param int $id ID de l'utilisateur
     * @return User
     */
    public static function find($id)
    {
        // connexion à la BDD
        $pdo = Database::getPDO();

        // déclaration de la requête
        $sql = 'SELECT * FROM `user` WHERE `id` =' . $id;

        // je récupère une instance de la class pdoStatement
        // à qui je donne ma requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat sous forme d'objet => fetchObject
        $result = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $result;
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
            `role`
            ) 
        VALUES (
            :firstname, 
            :lastname, 
            :email, 
            :password, 
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


    /**
     * Met à jour l'utilisateur courant en BDD
     * 
     * @return bool $result
     */
    public function update()
    {
        // récupération de PDO
        $pdo = Database::getPDO();

        // création de la requête préparée
        $sql = "UPDATE `user`
                SET `firstname` = :firstname,
                `lastname` = :lastname,
                `email` = :email,
                `role` = :role,
                `author_id` = :author_id,
                `updated_at` = NOW()
                WHERE id = :id ";

        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacement des tokens par leurs vraies valeurs
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':author_id', $this->author_id, PDO::PARAM_INT);

        
        // j'exécute la requête et le stocke le résultat dans une variable
        $result = $pdoStatement->execute();

        // je renvoie le résultat de la requête
        return $result;
    }

    /**
     * Méthode permettant de mettre à jour les informations du user courant
     */
    public function profilUpdate()
    {
        // récupération de PDO
        $pdo = Database::getPDO();

        // création de la requête préparée
        $sql = "UPDATE `user`
                SET `firstname` = :firstname,
                `lastname` = :lastname,
                `email` = :email,
                `updated_at` = NOW()
                WHERE id = :id ";

        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);

        // remplacement des tokens par leurs vraies valeurs
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);

        
        // j'exécute la requête et le stocke le résultat dans une variable
        $result = $pdoStatement->execute();

        // je renvoie le résultat de la requête
        return $result;
    }


    /**
     * Supprime l'utilisateur de la BDD
     *
     * @return bool
     */
    public function delete()
    {
        // récupération de PDO
        $pdo = Database::getPDO();

        // création de la requête 
        $sql = "DELETE FROM `user`
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