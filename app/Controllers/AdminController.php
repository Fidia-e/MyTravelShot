<?php

namespace App\Controllers;

use App\Models\User;

class AdminController extends CoreController {

    /**
     * Méthode affichant le formulaire de connexion
     *
     */
    public function login()
    {
        $this->show('login');
    }

    /**
     * Méthode permettant d'authentifier un utilisateur
     *
     * @return void
     */
    public function authenticate()
    {
        // récupération des informations du formulaire
        // nettoyage et validations des champs grâce à la fonction filter_input()
        $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        
        // je vérifie que l'utilsateur existe bien en bdd
        // avec l'adresse email fournie
        $user = User::findByEmail($email);

        // si l'utilisateur existe, on va vérifier son mot de passe
        if($user) {

            // je vérifie le mdp avec la fonction password_verify()
            if(password_verify($password, $user->getPassword())) {

                // si le mdp correspond, on stocke le user dans une session courante
                $_SESSION['currentUser'] = $user;

                // et je redirige vers la page d'accueil
                $this->redirect('main-home');

                // sinon je lui envoie un message d'erreur
            } else {
                echo "Le mot de passe n'est pas bon !";
            }
        } 
        // si l'email n'est pas reconnu, j'affiche le message d'eerreur suivant
        else {

            echo "L'email n'existe pas !";
        }
    }

    /**
     * Déconnecte l'utilsateur en supprimant l'utilisateur courant de la session
     *
     */
    public function logout()
    {
        // je retire l'entrée currentUser du tableau $_SESSION
        unset($_SESSION['currentUser']);
        
        // je redirige vers la page d'accueil
        $this->redirect('main-home');
    }

    
}