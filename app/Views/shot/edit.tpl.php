<div class="container my-4">
<br>
<a href="<?= $router->generate('shot-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification d'une publication</h2>

<form action="<?= $router->generate('shot-update', ['id' => $shot->getId()]) ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $token ?>">

    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control" value="<?= $shot->getTitle() ?>" name="title" id="title" placeholder="Titre de la publication">
    </div>
    <div class="form-group">
        <label for="picture">Photo</label>
        <input type="text" class="form-control" value="<?= $shot->getPicture() ?>" name="picture" id="picture" placeholder="Photo de la publication">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" value="<?= $shot->getDescription() ?>" name="description" id="description" placeholder="Description de la publication">
    </div>
    <div class="form-group">
        <label for="authorId">Identifiant auteur</label>
        <input type="text" class="form-control" value="<?= $shot->getAuthorId() ?>" name="authorId" id="authorId" placeholder="Identifiant de l'auteur">
    </div>
    <div class="form-group">
        <label for="user">Prénom auteur</label>
        <select class="custom-select" name="user" id="user" aria-describedby="userHelpBlock">
            <option value="" selected disabled>Choisir un utilisateur</option>
            <?php foreach($authors as $author): ?>
                <option value=""><?= $author->getUsername() ?></option>
            <?php endforeach; ?>
        </select>
        <small id="userHelpBlock" class="form-text text-muted">
            L'auteur associé
        </small>
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>