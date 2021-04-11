<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends CoreController {


    /**
     * Page listant les utilisateurs
     *
     */
    public function list()
    {
        // récupération de tous les users grâce à la méthode statique "findAll()"
        $users = User::findAll();

        // je fais un tableau de données à passer à ma vue.
        $viewVars = ['users' => $users];

        $this->show('user/list', $viewVars);
    }

    /**
     * Page affichant le formulaire d'ajout d'un utilisateur
     *
     * @return void
     */
    public function add()
    {
        // génération d'un token aléatoire 
        $token = $this->generateCsrfToken();

        $this->show('user/add', ['token' => $token]);
        // ne pas oublier d'ajouter le token au dessus comme 2e arg de show!!! ', ['token' => $token]'
    }

    /**
     * Méthode permettant d'ajouter un utilisateur en BDD
     *
     */
    public function create()
    {

        // récupération des valeurs des champs
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = filter_input(INPUT_POST, 'password');
        $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
        $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $token = filter_input(INPUT_POST, 'token');

        // création d'un tableau d'erreurs, vide
        $errorList = [];

        // vérification de la présence du token 
        // et de sa bonne correspondance avec la session
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF !";
        }

        // vérification des valeurs
        // si le prénom est vide
        if (empty($firstname)) {
        $errorList[] = 'Le prénom est vide.';
        }

        // si le nom est vide
        if (empty($lastname)) {
        $errorList[] = 'Le nom est vide.';
        }

        // si l'email est vide ou mal construit
        if ($email === false) {
        $errorList[] = 'L\'email est invalide ou vide.';
        }

        // si le mot de passe est vide
        if (empty($password)) {
        $errorList[] = 'Le mot de passe est vide.';
        }

        // si la ville n'est pas renseignée
        if (empty($city)) {
        $errorList[] = 'La ville est vide.';
        }

        // si le pays n'est pas renseigné
        if (empty($country)) {
        $errorList[] = 'Le pays est vide.';
        }

        // si le rôle n'est pas précisé
        if(empty($role)) {
            $errorList[] = 'Le rôle est vide.';
        }

        // si le rôle correspond à la liste des rôles demandés
        if($role != 'admin' && $role != 'author') {
            $errorList[] = "Le rôle n'existe pas";
        }

        // s'il n'y a pas d'erreurs (donc $errorList est vide)
        // alors j'enregistre l'utilisateur en BDD
        if(empty($errorList)) {
            
            // j'instancie un nouvel utilisateur
            $user = new User;

            // je définie les différentes propriétés de l'utilisateur
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setCity($city);
            $user->setCountry($country);
            $user->setRole($role);

            // j'appelle la méthode permettant de sauvegarder l'utilisateur en BDD
            $result = $user->save();
            
            // si la requête a marché, alors result = true, je redirige
            // sinon, j'ajoute un message d'erreur dans la liste.
            if($result) {

                // on efface le token de la session pour qu'il ne soit plus réutilisable
                // on ne peut donc pas soumettre plusieurs fois le même formulaire
                unset($_SESSION['csrfToken']);
                $this->redirect('user-list');

            } else {
                $errorList[] = "Une erreur a eu lieu lors de l'ajout";
            }

        } else {

            // j'affiche le formulaire avec les erreurs
            $viewVars = [
                'errorList' => $errorList,
                'inputValues' => [
                    'token' => $token,
                    'firstname' => filter_input(INPUT_POST, 'firstname'),
                    'lastname' => filter_input(INPUT_POST, 'lastname'),
                    'email' => filter_input(INPUT_POST, 'email'),
                    'city' => filter_input(INPUT_POST, 'city'),
                    'country' => filter_input(INPUT_POST, 'country'),
                ],
            ];

            $this->show('user/add', $viewVars);
        }
    }


    /**
     * Méthode permettant de modifier un utilisateur
     */
    public function update($userId)
    {
        // récupération du produit lié à l'ID présent dans l'URL
        $user = User::find($userId);

        // récupération des champs du formulaire
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
        $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

        // grâce aux setters, je mets à jour mon utilisateur 
        // et lui attribue ses nouvelles valeurs
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setCity($city);
        $user->setCountry($country);
        $user->setRole($role);

        // appel de la méthode save() qui va sauvegarder les nouvelles infos dans la BDD
        $product->save();
        
        // redirection vers la page de la liste des utilisateurs
        $this->redirect('user-list');

    }


    /**
     * Méthode permettant de supprimer un utilisateur de la BDD
     *
     * @param int $id
     * 
     */
    public function delete($userId)
    {
        // je charge un utilisateur depuis la BDD grâce à l'ID fourni
        $product = Product::find($userId);

        // j'appelle la méthode de suppression de mon objet
        $product->delete();

        // je redirige vers la liste
        $this->redirect('user-list');
    }
    
}  
