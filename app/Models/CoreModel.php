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

    /**
     * Méthode permettant de sauvegarde en BDD, n'importe quel model.
     * Si l'objet a un ID de défini, c'est qu'il existe déjà. Donc je dois mettre à jour son entrée en BDD.
     * Si l'objet n'a pas encore d'ID, il n'existe pas dans la BDD. Je dois donc l'insérer.
     */
    public function save()
    {
        // si pas d'ID, l'objet n'existe pas => on l'insère
        if($this->id == null) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }
}