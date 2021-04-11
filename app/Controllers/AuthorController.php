<?php

namespace App\Controllers;

use App\Models\Author;

class AuthorController extends CoreController {

    /**
     * Affiche la page des auteurs pour les users
     */
    
    public function browse()
    { 
        $datas = Author::findAll();
        $viewVars = ['authors' => $datas];
        // dd($datas);
        // dd('coucou');

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
        $datas = Author::findAll();
        $viewVars = ['authors' => $datas];
        // dd($datas);
        // dd('coucou');

        $this->show('author/list', $viewVars);
    }

    /**
     * Page affichant le formulaire d'ajout d'un auteur
     *
     * @return void
     */
    public function add()
    {
        $datas = Author::findAll();
        $viewVars = ['authors' => $datas];
        // génération d'un token aléatoire 
        $token = $this->generateCsrfToken();

        $this->show('author/add', ['token' => $token, 'authors' => $datas]);
        // ne pas oublier d'ajouter le token au dessus comme 2e arg de show!!! ', ['token' => $token]'
    }

    /**
     * Affiche la page d'édition d'un auteur
     */
    public function edit($id)
    {
        // Récupération de l'auteur lié à l'ID présent dans l'URL
        $author = Author::find($id);
        // $token = $this->generateCsrfToken();
        
        // Envoi de l'auteur chargé à la vue
        $this->show('author/edit', ['author' => $author, 'token' => $token ]);
    }
}