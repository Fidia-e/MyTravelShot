<?php

namespace App\Controllers;

use App\Models\Shot;
use App\Models\Author;

class ShotController extends CoreController {

    /**
     * Affiche la photos en fonction des auteurs
     */
    
    public function browseByAuthor($author_id)
    { 
        $datas = Shot::findByAuthorId($author_id);
        $viewVars = ['shotByAuthor' => $datas];
        // dd($datas);

        $this->show('authors_shots', $viewVars);
    }

    /* ---------------------------------------------------------------------------------------
    ----------------------------------------- ADMIN ------------------------------------------
    -----------------------------------------------------------------------------------------*/

    /**
     * Liste les shots pour l'admin
     *
     * @return void
     */
    public function list()
    {
        // je récupère la liste de tous mes auteurs
        $datas = Shot::findAll();

        // je les stocke dans un tableau viewVars
        $viewVars = ['shots' => $datas];

        // j'appelle ma méthode show qui va afficher le bon template
        // à qui je passe mon tableau de données viewVars
        $this->show('shot/list', $viewVars);
    }

    /**
     * Page affichant le formulaire d'ajout d'un shot
     *
     * @return void
     */
    public function add()
    {
        // je récupère mes auteurs 
        // pour pouvoir récupérer les utilisateurs correspondants
        $datas = Shot::findAll();
        $datasAuthor = Author::findAll();
        $viewVars = [
            'shots' => $datas,
            'authors' => $datasAuthor
        ];

        // génération d'un token aléatoire 
        $token = $this->generateCsrfToken();

        $this->show('shot/add', [
                            'token' => $token, 
                            'shots' => $datas,
                            'authors' => $datasAuthor,
                            ]);
    }

    /**
     * Méthode permettant d'ajouter un auteur en BDD
     *
     */
    public function create()
    {

        // récupération des valeurs des champs
        $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
        $picture = trim(filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING));
        $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
        $author_id = filter_input(INPUT_POST, 'author_id', FILTER_SANITIZE_NUMBER_INT);
        $token = filter_input(INPUT_POST, 'token');

        // création d'un tableau d'erreurs, vide
        $errorList = [];

        // vérification de la présence du token 
        // et de sa bonne correspondance avec la session
        if(empty($token) || $token != $_SESSION['csrfToken']){
            $errorList[] = "Erreur CSRF !";
        }

        // vérification des valeurs
        // si le titre est vide
        if (empty($title)) {
        $errorList[] = 'Le titre est vide.';
        }

        // si la photo n'est pas renseignée
        if (empty($picture)) {
        $errorList[] = 'La photo est vide.';
        }

        // si la description n'est pas renseignée
        if (empty($description)) {
        $errorList[] = 'La description est vide.';
        }

        // s'il n'y a pas d'erreurs (donc $errorList est vide)
        // alors j'enregistre l'utilisateur en BDD
        if(empty($errorList)) {
            
            // j'instancie une nouvelle publication
            $shot = new Author;

            // je définie les différentes propriétés de la publication
            $shot->setTitle($title);
            $shot->setPicture($picture);
            $shot->setDescription($description);
            $shot->setAuthorId($author_id);

            // j'appelle la méthode permettant de sauvegarder la publication en BDD
            $result = $user->save();
            
            // si la requête a marché, alors result = true, je redirige
            // sinon, j'ajoute un message d'erreur dans la liste.
            if($result) {

                // on efface le token de la session pour qu'il ne soit plus réutilisable
                // on ne peut donc pas soumettre plusieurs fois le même formulaire
                unset($_SESSION['csrfToken']);
                $this->redirect('shot-list');

            } else {
                $errorList[] = "Une erreur a eu lieu lors de l'ajout";
            }

        } else {

            // j'affiche le formulaire avec les erreurs
            $viewVars = [
                'errorList' => $errorList,
                'inputValues' => [
                    'token' => $token,
                    'title' => filter_input(INPUT_POST, 'title'),
                    'picture' => filter_input(INPUT_POST, 'picture'),
                    'description' => filter_input(INPUT_POST, 'description'),
                ],
            ];

            $this->show('shot/add', $viewVars);
        }
    }

    /**
     * Affiche la page d'édition d'un shot
     * 
     * @param int $id
     */
    public function edit($id)
    {
        // Récupération de l'auteur lié à l'ID présent dans l'URL
        $shot = Shot::find($id);
        // $token = $this->generateCsrfToken();
        
        // Envoi de l'auteur chargé à la vue
        $this->show('shot/edit', ['shot' => $shot, 'token' => $token ]);
    }

    /**
     * Méthode permettant de modifier un shot
     * 
     * @param int $id
     */
    public function update($id)
    {
        // récupération du shot lié à l'ID présent dans l'URL
        $shot = Shot::find($id);

        // récupération des champs du formulaire
        $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
        $picture = trim(filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING));
        $description = trim(filter_input(INPUT_POST, 'des$description', FILTER_SANITIZE_STRING));
        $author_id = filter_input(INPUT_POST, '$author_id', FILTER_SANITIZE_NUMBER_INT);

        // grâce aux setters, je mets à jour ma publication 
        // et lui attribue ses nouvelles valeurs
        $shot->setTitle($title);
        $shot->setPicture($picture);
        $shot->setDescritpion($description);
        $shot->setAuthorId($author_id);

        // appel de la méthode save() qui va sauvegarder les nouvelles infos dans la BDD
        $product->save();
        
        // redirection vers la page de la liste des publications
        $this->redirect('shot-list');

    }

    /**
     * Méthode permettant de supprimer une publication de la BDD
     *
     * @param int $id
     * 
     */
    public function delete($id)
    {
        // je charge un auteur depuis la BDD grâce à l'ID fourni
        $shot = Shot::find($id);

        // j'appelle la méthode de suppression de mon objet
        $shot->delete();

        // je redirige vers la liste
        $this->redirect('shot-list');
    }

}