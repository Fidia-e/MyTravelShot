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
        // Récupération des informations du formulaire
        $email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        
        // Vérifier que l'utilsateur avec cette adresse existe
        $user = User::findByEmail($email);

        // Si l'utilisateur existe, on va vérifier son mot de passe
        if($user) {

            // je vérifie le mdp
            if(password_verify($password, $user->getPassword())) {

                // si le mdp correspond, on stocke le user dans une session courante
                $_SESSION['currentUser'] = $user;


                dd('coucou');
                // et je redirige vers le BO
                $this->redirect('author-list');

                // sinon je lui envoie un message 
            } else {
                dd('coucou 1');
                echo "Les identifiants ne sont pas bons !";
            }
            
        } 
        // Sinon on affiche une message d'erreur
        else {
            dd('coucou 2');
            echo "L'email n'existe pas !";
        }

    }

    /**
     * Déconnecte l'utilsateur en supprimant l'entrée currentUser de la session
     *
     */
    public function logout()
    {
        // je retire l'entrée currentUser du tableau $_SESSION
        unset($_SESSION['currentUser']);
        // je redirige
        $this->redirect('main-home');
    }

    /**
     * Page listant les utilisateurs
     *
     */
    public function browseUsers()
    {
        // Vérification du rôle de l'user connecté
        // Il faut impérativement être admin pour avoir accès à la page.
        // Plus besoin maintenant que c'est géré dans le coreController
        // $this->checkAuthorization(['admin']);

        // Récupération de tous les users grâce à la méthode statique "findAll()"
        $users = AppUser::findAll();
        // Je fais un tableau de données à passer à ma vue.
        $viewVars = ['users' => $users];

        $this->show('user/list', $viewVars);
    }

    /**
     * Page affichant le formulaire d'ajout d'un utilisateur
     *
     * @return void
     */
    public function addUsers()
    {
        // Vérification du rôle de l'user connecté
        // Il faut impérativement être admin pour avoir accès à la page.
        // $this->checkAuthorization(['admin']);

        // Génération d'un token aléatoire 
        $token = $this->generateCsrfToken();

        $this->show('user/add', ['token' => $token]);
    }
    
}