<?php

namespace App\Controllers;

use App\Models\Author;
use App\Models\User;

class AuthorController extends CoreController {

    /**
     * Affiche la page des auteurs pour les users
     */
    
    public function browse()
    { 
        // je récupère la liste de tous mes auteurs
        $datas = Author::findAll();

        // je les stocke dans un tableau viewVars
        $viewVars = ['authors' => $datas];

        // j'appelle ma méthode show qui va afficher le bon template
        // à qui je passe mon tableau de données viewVars
        $this->show('authors', $viewVars);
    }

    /* ---------------------------------------------------------------------------------------
    ----------------------------------------- ADMIN ------------------------------------------
    -----------------------------------------------------------------------------------------*/

    /**
     * Liste les auteurs pour l'admin
     *
     * @return void
     */
    public function list()
    {
        // je récupère la liste de tous mes auteurs
        $datas = Author::findAll();
        $datasUser = [];
        foreach($datas as $author){
            $datasUser[$author->getId()] = $author->getUserInformations();
        }

        // génération d'un token CSRF 
        $token = $this->generateCsrfToken();

        // je les stocke dans un tableau viewVars
        $viewVars = [
                'authors' => $datas, 
                'users' => $datasUser,
                'token' =>$token,
                ];

        // j'appelle ma méthode show qui va afficher le bon template
        // à qui je passe mon tableau de données viewVars
        $this->show('author/list', $viewVars);
    }

    /**
     * Page affichant le formulaire d'ajout d'un auteur
     *
     * @return void
     */
    public function add()
    {
        // je récupère mes auteurs 
        // pour pouvoir récupérer les utilisateurs correspondants
        $datas = Author::findAll();
        $datasUser = User::findAll();

        // génération d'un token aléatoire 
        $token = $this->generateCsrfToken();
        
        $viewVars = [
                    'authors' => $datas, 
                    'users' => $datasUser,
                    'token' => $token
                ];


        $this->show('author/add', $viewVars);
    }

    /**
     * Méthode permettant d'ajouter un auteur en BDD
     *
     */
    public function create()
    {
        // récupération et validation des valeurs des champs
        // filter_input() vérifie les variables envoyées par l'utilisateur :
            // elle renvoie :
            // la valeur de la variable en cas de succès
            // FALSE en cas d'échec 
            // NULL si la variable n'est pas définie
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
        $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
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
        if (empty($username)) {
        $errorList[] = 'Le pseudo est vide.';
        }

        // si la ville n'est pas renseignée
        if (empty($city)) {
        $errorList[] = 'La ville est vide.';
        }

        // si le pays n'est pas renseigné
        if (empty($country)) {
        $errorList[] = 'Le pays est vide.';
        }

        // s'il n'y a pas d'erreurs (donc $errorList est vide)
        // alors j'enregistre l'utilisateur en BDD
        if(empty($errorList)) {
            
            // j'instancie un nouvel utilisateur
            $author = new Author;

            // je définie les différentes propriétés de l'utilisateur
            $author->setUsername($username);
            $author->setCity($city);
            $author->setCountry($country);
            $author->setUserId($user_id);

            // j'appelle la méthode permettant de sauvegarder l'utilisateur en BDD
            $result = $author->save();
            
            // si la requête a marché, alors result = true, je redirige
            // sinon, j'ajoute un message d'erreur dans la liste.
            if($result) {

                // on efface le token de la session pour qu'il ne soit plus réutilisable
                // on ne peut donc pas soumettre plusieurs fois le même formulaire
                unset($_SESSION['csrfToken']);
                $this->redirect('author-list');

            } else {
                $errorList[] = "Une erreur a eu lieu lors de l'ajout";
            }

        } else {

            // j'affiche le formulaire avec les erreurs
            $viewVars = [
                'errorList' => $errorList,
                'inputValues' => [
                    'token' => $token,
                    'username' => filter_input(INPUT_POST, 'username'),
                    'city' => filter_input(INPUT_POST, 'city'),
                    'country' => filter_input(INPUT_POST, 'country'),
                ],
            ];

            $this->show('author/add', $viewVars);
        }
    }

    /**
     * Affiche la page d'édition d'un auteur
     * 
     * @param int $id
     */
    public function edit($id)
    {
        // récupération de l'auteur lié à l'ID présent dans l'URL
        $author = Author::find($id);
        $datasUser = User::findAll();
        $token = $this->generateCsrfToken();

        $viewVars = [
            'author' => $author, 
            'users' => $datasUser,
            'token' => $token
        ];
        

        // envoi de l'auteur chargé à la vue
        $this->show('author/edit', $viewVars);
    }

    /**
     * Méthode permettant de modifier un utilisateur
     * 
     * @param int $id
     */
    public function update($id)
    {
        // récupération de l'auteur lié à l'ID présent dans l'URL
        $author = Author::find($id);

        // récupération des champs du formulaire
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
        $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);

        // création d'un tableau d'erreurs, vide
        $errorList = [];

        // vérification de la présence du token CSRF dans le formulaire
        // et qu'il correspond bien à celui de la session
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF ! Bien essayé.";
        }

        // grâce aux setters, je mets à jour mon auteur 
        // et lui attribue ses nouvelles valeurs
        $author->setUsername($username);
        $author->setCity($city);
        $author->setCountry($country);
        $author->setUserId($user_id);
        
        // appel de la méthode save() qui va sauvegarder les nouvelles infos dans la BDD
        $author->save();
        
        // on efface le token de la session pour qu'il ne soit plus réutilisable
        // on ne peut donc pas soumettre plusieurs fois le même formulaire
        unset($_SESSION['csrfToken']);

        // redirection vers la page de la liste des utilisateurs
        $this->redirect('author-list');

    }

    /**
     * Méthode permettant de supprimer un auteur de la BDD
     *
     * @param int $id
     * 
     */
    public function delete($id)
    {
        // je charge un auteur depuis la BDD grâce à l'ID fourni
        $author = Author::find($id);

        // j'appelle la méthode de suppression de mon objet
        $author->delete();

        // je redirige vers la liste
        $this->redirect('author-list');
    }
}