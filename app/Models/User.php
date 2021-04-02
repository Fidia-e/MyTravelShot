<?php

namespace App\Models;

use App\Utils\Database;
use PDO;


// class de mon entité `User` 
// étendue du CoreModel
class User extends CoreModel {

    protected $firstname;
    protected $lastname;
    protected $email;
    protected $password;
    protected $city;
    protected $country;
    protected $role;


    /**
     * Methode me permettant de récuperer tous les utilisateurs
     *
     * @return array User[] // je vais récupérer un tableau d'objets
     */
    public static function findAll()
    {
        // je me connecte ma BDD grâce
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


}