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
        $datas = Shot::findAll();
        shuffle($datas);
        $datasAuthor = [];
        foreach($datas as $shot){
            $datasAuthor[$shot->getId()] = Author::find($shot->getAuthorId());
        }

        $viewVars = [
            'shots' => $datas,
            'authors' => $datasAuthor
        ];

        $this->show('home', $viewVars);
    }
}