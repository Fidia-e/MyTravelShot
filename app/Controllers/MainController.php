<?php

namespace App\Controllers;

use App\Models\Shot;

class MainController extends CoreController {

    /**
     * Affiche la page d'accueil
     */
    
    public function home()
    { 
        $datas = Shot::findAll();
        $viewVars = ['shots' => $datas];

        $this->show('home', $viewVars);
    }
}