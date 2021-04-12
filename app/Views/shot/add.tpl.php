<div class="container my-4">
<br>
<a href="<?= $router->generate('shot-list') ?>" class="btn btn-success float-right">Retour</a>

<h2>Ajouter une publication</h2>
<?php if(isset($errorList)) :  ?>
    <?php foreach($errorList as $error) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
<form action="<?= $router->generate('shot-create') ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $token ?>">
  
    <div class="form-group">
        <label for="title">Titre</label>
        <input value="<?= (isset($inputValues['title'])) ? $inputValues['title']: '' ?>" type="text" class="form-control" name="title" id="title" placeholder="Titre de la publication">
    </div>
    <div class="form-group">
        <label for="picture">Photo</label>
        <input value="<?= (isset($inputValues['picture'])) ? $inputValues['picture']: '' ?>" type="text" class="form-control" name="picture" id="picture" placeholder="Photo de la publication">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input value="<?= (isset($inputValues['description'])) ? $inputValues['description']: '' ?>" type="text" class="form-control" name="description" id="description" placeholder="Descitpion de la publication">
    </div>  
    <div class="form-group">
        <label for="author_id">Identifiant utilisateur</label>
        <select class="custom-select" name="author_id" id="author_id" aria-describedby="authorIdHelpBlock">
            <option value="" selected disabled>Choisir un auteur</option>
            <?php foreach($datasAuthor as $author): ?>
                <option value=""><?= $author->getUsername() ?></option>
            <?php endforeach; ?>
        </select>
        <small id="authorIdHelpBlock" class="form-text text-muted">
            L'auteur associé
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Ajouter</button>
</form>