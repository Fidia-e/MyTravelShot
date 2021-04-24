<?php

namespace App\Controllers;

use App\Models\Shot;
use App\Models\Author;

class MainController extends CoreController {

    /**
     * Affiche la page d'accueil
     */
    
    public function home()
    { 
        // récupération toutes les publications
        // avec la fonction suffle() j'affiche mes photos de manière aléatoire
        // à chaque rechargement de page
        $datas = Shot::findAll();
        shuffle($datas);

        // je définie $datasAuthor comme tableau vide
        // je boucle sur chaque publication
        // et je viens remplir $datasAuthor avec les informations auteur
        // respectives à chaque publication
        $datasAuthor = [];
        foreach($datas as $shot){
            $datasAuthor[$shot->getId()] = Author::find($shot->getAuthorId());
        }
        
        // définition du tableau de données $viewVars
        // où je stocke tout ce que j'envoie à la vue
        $viewVars = [
            'shots' => $datas,
            'authors' => $datasAuthor
        ];

        // j'appelle ma méthode show qui va afficher le bon template
        // à qui je passe mon tableau de données $viewVars
        $this->show('home', $viewVars);
    }
}