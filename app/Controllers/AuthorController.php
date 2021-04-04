<?php

namespace App\Controllers;

use App\Models\Author;

class AuthorController extends CoreController {

    /**
     * Affiche la page des auteurs
     */
    
    public function browse()
    { 
        $datas = Author::findAll();
        $viewVars = ['authors' => $datas];
        // dd($datas);
        // dd('coucou');

        $this->show('author/list', $viewVars);
    }

    /**
     * Affiche la page d'édition d'un auteur
     */
    public function edit($id)
    {
        // Récupération de l'auteur lié à l'ID présent dans l'URL
        $author = Author::find($id);
        $token = $this->generateCsrfToken();
        
        // Envoi de l'auteur chargé à la vue
        $this->show('author/edit', ['author' => $author, 'token' => $token ]);
    }
}