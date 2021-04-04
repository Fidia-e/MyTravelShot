<?php

namespace App\Models;


// création de ma class modèle 
// elle ne représente aucune une entité en BDD
// elle sert de modèles pour les autres class (entités)
// elle ne sera jamais instanciéé mais uniquement étendue

class CoreModel
{
    protected $id;
    protected $created_at;
    protected $updated_at;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}