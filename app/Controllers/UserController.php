<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends CoreController {

    /**
     * Méthode permettant d'ajouter un utilisateur en BDD.
     *
     */
    public function create()
    {

        // récupération des valeurs des champs
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = filter_input(INPUT_POST, 'password');
        $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
        $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $token = filter_input(INPUT_POST, 'token');

        // création d'un tableau d'erreurs, vide
        $errorList = [];

        // vérification du token de la session
        // s'il correspond bien au user courant
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF. Va hacker ailleurs !";
        }

        // vérification des valeurs
        // si l'email est incorrecte
        if ($email === false) {
        $errorList[] = 'L\'email est invalide ou vide.';
        }
        // si le mot de passe est vide
        if (empty($password)) {
        $errorList[] = 'Le mot de passe est vide.';
        }

        // si le prénom est vide
        if (empty($firstname)) {
        $errorList[] = 'Le prénom est vide.';
        }

        // si le nom est vide
        if (empty($lastname)) {
        $errorList[] = 'Le nom est vide.';
        }

        // si le rôle n'est pas choisi
        if(empty($role)) {
            $errorList[] = 'Le rôle est vide.';
        }

        // si le rôle correspond à la liste des rôles demandés
        if($role != 'admin' && $role != 'catalog-manager') {
            $errorList[] = "Le rôle n'existe pas.";
        }

        // s'il n'y a pas d'erreurs (donc $errorList est vide), alors on peut enregistrer l'utilisateur en BDD.
        if(empty($errorList)) {
            
            // j'instancie un nouvel utilisateur
            $user = new User;

            // je définie les différentes propriétés de l'utilisateur.
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setCity($city);
            $user->setCountry($country);
            $user->setRole($role);

            // j'appelle la méthode permettant de sauvegarder l'utilisateur en BDD.
            $result = $user->save();
            
            // Si la requête a marché, alors result = true, je redirige. Sinon, j'ajoute un message d'erreur dans la liste.
            if($result) {
                // On efface le token de la session pour qu'il ne soit plus réutilisable. On ne peut donc pas soumettre plusieurs fois le même formulaire.
                unset($_SESSION['csrfToken']);
                $this->redirect('user-list');
            } else {
                $errorList[] = "Une erreur a eu lieu lors de l'ajout";
            }

        } else {
            // j'affiche le formulaire avec les erreurs.
            $viewVars = [
                'errorList' => $errorList,
                'inputValues' => [
                    'token' => $token,
                    'email' => filter_input(INPUT_POST, 'email'),
                    'firstname' => filter_input(INPUT_POST, 'firstname'),
                    'lastname' => filter_input(INPUT_POST, 'lastname'),
                ],
            ];

            $this->show('user/add', $viewVars);
        }


    }
}