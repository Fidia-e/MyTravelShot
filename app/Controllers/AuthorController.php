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

        $this->show('author', $viewVars);
    }
}