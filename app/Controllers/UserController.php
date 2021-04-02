<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends CoreController {

    /**
     * Affiche la page des utilisateurs
     */
    
    public function browse()
    { 
        $datas = User::findAll();
        $viewVars = ['users' => $datas];
        // dd($datas);

        $this->show('user', $viewVars);
    }
}