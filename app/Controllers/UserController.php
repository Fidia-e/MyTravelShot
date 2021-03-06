<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends CoreController {

    /**
     * Page listant les utilisateurs
     */
    public function list()
    {
        // récupération de tous les users grâce à la méthode statique "findAll()"
        $users = User::findAll();

        // génération d'un token aléatoire
        // pour protéger la route
        $token = $this->generateCsrfToken();

        // définition du tableau de données $viewVars à passer à ma vue
        $viewVars = [
            'users' => $users,
            'token' => $token,
        ];

        // j'appelle ma méthode show qui va afficher le bon template
        // à qui je passe mon tableau de données viewVars
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

        // j'appelle ma méthode show qui va afficher le bon template
        // à qui je passe le token
        $this->show('user/add', ['token' => $token]);
    }

    /**
     * Méthode permettant d'ajouter un utilisateur en BDD
     */
    public function create()
    {
        // récupération et validation des valeurs des champs
        // filter_input() vérifie les variables envoyées par l'utilisateur :
            // elle renvoie :
            // la valeur de la variable en cas de succès
            // FALSE en cas d'échec 
            // NULL si la variable n'est pas définie
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = filter_input(INPUT_POST, 'password');
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $token = filter_input(INPUT_POST, 'token');

        // création d'un tableau d'erreurs, vide
        $errorList = [];

        // vérification de la présence du token CSRF dans le formulaire
        // et qu'il correspond bien à celui de la session
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF ! Bien essayé.";
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

        // si le rôle n'est pas précisé
        if(empty($role)) {
            $errorList[] = 'Le rôle est vide.';
        }

        // si le rôle correspond à la liste des rôles demandés
        if($role != 'admin' && $role != 'author' && $role != 'superadmin') {
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
            $user->setRole($role);

            // j'appelle la méthode permettant de sauvegarder l'utilisateur en BDD
            $result = $user->save();
            
            // si la requête a marché, alors result = true, je redirige
            // sinon, j'ajoute un message d'erreur dans la liste d'erreurs
            if($result) {

                // on efface le token de la session pour qu'il ne soit plus réutilisable
                // on ne peut donc pas soumettre plusieurs fois le même formulaire
                unset($_SESSION['csrfToken']);
                $this->redirect('user-list');

            } else {
                $errorList[] = "Une erreur a eu lieu lors de l'ajout";
            }

        } else {

            // sinon, j'affiche le formulaire avec les erreurs
            $viewVars = [
                // j'affiche les erreurs
                'errorList' => $errorList,

                // pour éviter à l'utilisateur de tout retaper 
                // je préremplis les champs avec ce qu'il envoyé
                'inputValues' => [
                    'token' => $token,
                    'firstname' => filter_input(INPUT_POST, 'firstname'),
                    'lastname' => filter_input(INPUT_POST, 'lastname'),
                    'email' => filter_input(INPUT_POST, 'email'),
                ],
            ];

            // j'appelle ma méthode show qui va afficher le bon template
            // à qui je passe mon tableau de données viewVars
            $this->show('user/add', $viewVars);
        }
    }

    /**
     * Affiche la page d'édition d'un utilisateur
     * 
     * @param int $id
     */
    public function edit($id)
    {
        // récupération du utilisateur lié à l'ID présent dans l'URL
        $user = User::find($id);

        // je protège la route avec un CSRF token
        $token = $this->generateCsrfToken();
        
        // je définie le tableau $viewVars contenant les données à passer à ma vue
        $viewVars = [
                'user' => $user, 
                'token' => $token
                ];


        // envoi de l'utilisateur chargé à la vue
        // avec les données
        $this->show('user/edit', $viewVars);
    }

    /**
     * Méthode permettant de modifier un utilisateur
     * 
     * @param int $id
     */
    public function update($id)
    {
        // récupération de l'utilisateur lié à l'ID présent dans l'URL
        $user = User::find($id);

        // récupération et validation des valeurs des champs
        // filter_input() vérifie les variables envoyées par l'utilisateur :
            // elle renvoie :
            // la valeur de la variable en cas de succès
            // FALSE en cas d'échec 
            // NULL si la variable n'est pas définie
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS));
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
        $token = filter_input(INPUT_POST, 'token');

        // création d'un tableau d'erreurs, vide
        $errorList = [];

        // vérification de la présence du token CSRF dans le formulaire
        // et qu'il correspond bien à celui de la session
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF ! Bien essayé.";
        }

        if(empty($errorList)){

            // grâce aux setters, je mets à jour mon utilisateur 
            // et lui attribue ses nouvelles valeurs
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setRole($role);
            
            // appel de la méthode save() qui va sauvegarder les nouvelles infos dans la BDD
            $user->save();
            
            // on efface le token de la session pour qu'il ne soit plus réutilisable
            // on ne peut donc pas soumettre plusieurs fois le même formulaire
            unset($_SESSION['csrfToken']);
            
            // redirection vers la page de la liste des utilisateurs
            $this->redirect('user-list');
            
        } else {
            // j'affiche le formulaire avec les erreurs
            // puis je récupère ce qu'il a entré dans les champs
            // pour préremplir les champs
            // et lui éviter de tout rentrer à nouveau
            $viewVars = [
                'errorList' => $errorList,
                'inputValues' => [
                    'token' => $token,
                    'firstname' => filter_input(INPUT_POST, 'firstname'),
                    'lastname' => filter_input(INPUT_POST, 'lastname'),
                    'email' => filter_input(INPUT_POST, 'email'),
                ],
            ];

            // j'appelle ma méthode show qui va afficher le bon template
            // à qui je passe mon tableau de données viewVars
            $this->show('user/edit', $viewVars);
        }
    }

    /**
     * Méthode permettant de supprimer un utilisateur de la BDD
     *
     * @param int $id
     * 
     */
    public function delete($id)
    {
        // je charge un utilisateur depuis la BDD grâce à l'ID fourni
        $user = User::find($id);

        // j'appelle la méthode de suppression de mon objet
        $user->delete();

        // je redirige vers la liste
        $this->redirect('user-list');
    }

    /* ---------------------------------------------------------------------------------------
    ----------------------------------------- PROFIL -----------------------------------------
    -----------------------------------------------------------------------------------------*/

    /**
     * Méthode permettant d'afficher les informations du user courant
     */
    public function showProfil()
    {
        // génération d'un token aléatoire 
        // pour protéger la route
        $token = $this->generateCsrfToken();

        // appel de la méthode shwo() qui affcihe la vue
        // à qui je passe le token
        $this->show('user/profil', ['token' => $token]);
    }

    /**
     * Méthode permettant d'afficher le formulaire d'édition
     * des informations du user courant
     */
    public function editProfil()
    {
        // récupération du utilisateur courant stocké en session
        $user = $_SESSION['currentUser'];

        // génération d'un token CSRF
        $token = $this->generateCsrfToken();
        
        // définition du tableau contenant les informations 
        // à envoyer à la vue
        $viewVars = [
                'user' => $user, 
                'token' => $token
                ];

        // appel de la méthode show() qui affiche la vue et les données passées
        $this->show('user/profil-edit', $viewVars);
    }
    
    /**
     * Méthode permettant de mettre à jour les informations du user courant
     */
    public function updateProfil()
    {
        // récupération du utilisateur courant stocké en session
        $user = $_SESSION['currentUser'];

        // récupération et validation des champs du formulaire
        $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
        $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));

        // création d'un tableau d'erreurs, vide
        $errorList = [];

        // vérification de la présence du token CSRF dans le formulaire
        // et qu'il correspond bien à celui de la session
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF ! Bien essayé.";
        }

        // grâce aux setters, je mets à jour mon utilisateur 
        // et lui attribue ses nouvelles valeurs
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);

        // appel de la méthode save() qui va sauvegarder les nouvelles infos en BDD
        $user->save();
        
        // on efface le token de la session pour qu'il ne soit plus réutilisable
        // on ne peut donc pas soumettre plusieurs fois le même formulaire
        unset($_SESSION['csrfToken']);

        // redirection vers la page de la liste des utilisateurs
        $this->redirect('user-showprofil');

    }
}  
