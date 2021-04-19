<div class="container my-4">
<br>
<a href="<?= $router->generate('author-list') ?>" class="btn btn-success float-right">Retour</a>

<h2>Ajouter un auteur</h2>
<?php if(isset($errorList)) :  ?>
    <?php foreach($errorList as $error) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
<form action="<?= $router->generate('author-create') ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $token ?>">
  
    <div class="form-group">
        <label for="firstname">Pseudo</label>
        <input value="<?= (isset($inputValues['pseudo'])) ? $inputValues['pseudo']: '' ?>" type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Pseudo de l'auteur">
    </div>
    <div class="form-group">
        <label for="city">Ville</label>
        <input value="<?= (isset($inputValues['city'])) ? $inputValues['city']: '' ?>" type="text" class="form-control" name="city" id="city" placeholder="Ville de l'auteur">
    </div>
    <div class="form-group">
        <label for="country">Pays</label>
        <input value="<?= (isset($inputValues['country'])) ? $inputValues['country']: '' ?>" type="text" class="form-control" name="country" id="country" placeholder="Pays de l'auteur">
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
    <button type="submit" class="btn btn-primary btn-block mt-5">Ajouter</button>
</form>