<div class="container my-4">
<br>
<a href="<?= $router->generate('author-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification d'un auteur</h2>

<form action="<?= $router->generate('author-update', ['id' => $author->getId()]) ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $token ?>">

    <div class="form-group">
        <label for="username">Pseudo</label>
        <input type="text" class="form-control" value="<?= $author->getUsername() ?>" name="username" id="username" placeholder="Pseudo de l'auteur">
    </div>
    <div class="form-group">
        <label for="city">Ville</label>
        <input type="text" class="form-control" value="<?= $author->getCity() ?>" name="city" id="city" placeholder="Ville de l'auteur">
    </div>
    <div class="form-group">
        <label for="country">Pays</label>
        <input type="text" class="form-control" value="<?= $author->getCountry() ?>" name="country" id="country" placeholder="Pays de l'auteur">
    </div>
    <div class="form-group">
        <label for="userId">Prénom utilisateur</label>
        <input type="text" class="form-control" value="<?= $author->getUserId() ?>" name="userId" id="userId" placeholder="Pays de l'auteur">
    </div>
    <div class="form-group">
        <label for="user">Prénom utilisateur</label>
        <select class="custom-select" name="user" id="user" aria-describedby="userHelpBlock">
            <option value="" selected disabled>Choisir un utilisateur</option>
            <?php foreach($users as $user): ?>
                <option value="<?= $user->getId() ?>"><?= $user->getFirstname() ?></option>
            <?php endforeach; ?>
        </select>
        <small id="userHelpBlock" class="form-text text-muted">
            L'utilisateur associé
        </small>
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>