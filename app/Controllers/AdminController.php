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

                // et je redirige vers le BO
                $this->redirect('author/list');

                // sinon je lui envoie un message 
            } else {
                echo "Les identifiants ne sont pas bons !";
            }
            
        } 
        // Sinon on affiche une message d'erreur
        else {
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

    /**
     * Méthode permettant d'ajouter un utilisateur en BDD.
     *
     */
    public function create()
    {

        // Vérification du rôle de l'user connecté
        // Il faut impérativement être admin pour avoir accès à la page.
        // $this->checkAuthorization(['admin']);

        // Récupération des valeurs des champs
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = filter_input(INPUT_POST, 'password');
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status');
        $token = filter_input(INPUT_POST, 'token');

        // Création d'un tableau d'erreurs, vide
        $errorList = [];

        // Vérification de la présence du token et de se bonne correspondance avec la session
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF. Va hacker ailleurs !";
        }

        // Vérification des valeurs
        // @copyright 2020 Vincent
        // Si l'email est vide ou mal construit
        if ($email === false) {
        $errorList[] = 'L\'email est invalide ou vide.';
        }
        // Si le mot de passe est vide
        if (empty($password)) {
        $errorList[] = 'Le mot de passe est vide.';
        }

        // Si le prénom est vide
        if (empty($firstname)) {
        $errorList[] = 'Le prénom est vide.';
        }

        // Si le nom est vide
        if (empty($lastname)) {
        $errorList[] = 'Le nom est vide.';
        }

        if(empty($role)) {
            $errorList[] = 'Le rôle est vide.';
        }
        // Si le rôle correspond à la liste des rôles demandés
        if($role != 'admin' && $role != 'catalog-manager') {
            $errorList[] = "Le rôle n'existe pas.";
        }
        // Si le statut correspond à la liste des status demandés
        if($status != '1' && $status != '2') {
            $errorList[] = "Le statut n'existe pas.";
        }

        // S'il n'y a pas d'erreurs (donc $errorList est vide), alors on peut enregistrer l'utilisateur en BDD.
        if(empty($errorList)) {
            
            // J'instance un nouvel utilisateur
            $user = new AppUser;

            // On définit les différentes propriétés de l'utilisateur.
            // @copyright 2020 Frédéric & Marjolaine
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setRole($role);
            $user->setStatus($status);
            // On appelle la méthode permettant de sauvegarder l'utilisateur en BDD.
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