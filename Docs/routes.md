## Routes

| URL | Méthode HTTP | Controller | Méthode | Contenu | Commentaire |
|--|--|--|--|--|--|--|
|`/`|`GET`|`MainController`|`home`|Page d'accueil du site|Liste de toutes les publications|
|`/auteurs`|`GET`|`AuthorController`|`browse`|Page auteurs|Piste tous les auteurs du site|
|`/auteurs/photos/[i:author_id]`|`GET`|`ShotController`|`browseByAuthor`|Photos de chaque auteur|Liste les publications respectives de chaque auteur|
|`/login`|`GET`|`AdminController`|`login`|Formulaire de connexion|-|
|`/login`|`POST`|`AdminController`|`authenticate`|-|Envoie les informations entrées par l'utilisateur|
|`/logout`|`GET`|`AdminController`|`logout`|-|Product details|déconnecte l'utilisateur en visant la session|
|`/profil`|`GET`|`UserController`|`showProfil`|Profil utilisateur|Informations personnelles du user courant|
|`/profil/modifier`|`GET`|`UserController`|`editProfil`|Formulaire de modification|Permet à l'utilisateur de modifier ses informations personnelles|
|`/profil/modifier`|`POST`|`UserController`|`updateProfil`|-|Envoie les informations utilisateur mises à jour|
|`/shots/liste`|`GET`|`ShotController`|`list`|Liste de toutes les publications|Visible seulement pour les utilisateurs connectés|
|`/shots/ajouter`|`GET`|`ShotController`|`add`|Formulaire d'ajout d'une publication|visibles pour tous les rôles|
|`/shots/ajouter`|`POST`|`ShotController`|`create`|-|Envoie les informations créées|
|`/shots/modifier/[i:id]`|`GET`|`ShotController`|`edit`|Formulaire de modification d'une publications|Affiche le formulaire si la publication appartient à l'utilisateur connecté|
|`/shots/modifier/[i:id]`|`POST`|`ShotController`|`update`|-|Envoie les informations mises à jour|
|`/shots/[i:id]/supprimer`|`GET`|`ShotController`|`delete`|-|Supprime la donnée qui correspond à l'id envoyé|
|`/auteurs/liste`|`GET`|`AuthorController`|`list`|Liste de tous les auteurs|Visibles seulement pour les utilisateurs connectés|
|`/auteurs/ajouter`|`GET`|`AuthorController`|`add`|Formulaire d'ajout d'un auteur|visible pour les rôles ayant les droits|
|`/auteurs/ajouter`|`POST`|`AuthorController`|`create`|-|Envoie les informations créées|
|`/auteurs/modifier/[i:id]`|`GET`|`AuthorController`|`edit`|Formulaire de modification d'un auteur|Affiche le formulaire de modification qu'aux rôles ayant les droits|
|`/auteurs/modifier/[i:id]`|`POST`|`AuthorController`|`update`|-|Envoie les informations mises à jour|
|`/auteurs/[i:id]/supprimer`|`GET`|`AuthorController`|`delete`|-|Supprime la donnée qui correspond à l'id envoyé|
|`/utilisateurs/liste`|`GET`|`UserController`|`list`|Liste de tous les utilisateurs|visibles seulement pour les utilisateurs connectés|
|`/utilisateurs/ajouter`|`GET`|`UserController`|`add`|Formulaire d'ajout d'un utilisateur|Visibles pour les rôles ayant les droits|
|`/utilisateurs/ajouter`|`POST`|`UserController`|`create`|-|Envoie les informations créées|
|`/utilisateurs/modifier/[i:id]`|`GET`|`UserController`|`edit`|Formulaire de modification d'un utilisateur|Visible qu'aux rôles ayant les droits|
|`/utilisateurs/modifier/[i:id]`|`POST`|`UserController`|`update`|-|Envoie les informations mises à jour|
|`/utilisateurs/[i:id]/supprimer`|`GET`|`UserController`|`delete`|-|Supprime la donnée qui correspond à l'id envoyé|
