<?php

namespace App\Models;


// création de ma class modèle 
// elle ne représente aucune une entité en BDD
// elle sert de modèles pour les autres class (entités)
// elle ne sera jamais instanciéé mais uniquement étendue (car abstract)

abstract class CoreModel
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
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Méthode permettant de sauvegarde en BDD, n'importe quel model
     * si l'objet a un ID de défini, c'est qu'il existe déjà
     *      -> donc je dois mettre à jour son entrée en BDD
     * si l'objet n'a pas encore d'ID, il n'existe pas dans la BDD
     *      -> je dois donc l'insérer
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

    // avec le mot-clé abstract on peut venir définir des méthodes qui devront obligatoirement 
    // être dans les méthodes enfant de cette classe
    // pour que ma méthode save() fonctionne 
    abstract protected function insert();
    abstract protected function update();
    abstract protected static function find($id);
    abstract protected static function findAll();

}