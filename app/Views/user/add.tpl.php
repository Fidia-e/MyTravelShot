<div class="container my-4">
<br>
<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>

<h2>Ajouter un utilisateur</h2>
<?php if(isset($errorList)) :  ?>
    <?php foreach($errorList as $error) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
<form action="<?= $router->generate('user-create') ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $token ?>">
  
    <div class="form-group">
        <label for="firstname">Prénom</label>
        <input value="<?= (isset($inputValues['firstname'])) ? $inputValues['firstname']: '' ?>" type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="lastname">Nom</label>
        <input value="<?= (isset($inputValues['lastname'])) ? $inputValues['lastname']: '' ?>" type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input value="<?= (isset($inputValues['email'])) ? $inputValues['email']: '' ?>" type="email" class="form-control" name="email" id="email" placeholder="Email de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe de l'utilisateur">
    </div>  
    <div class="form-group">
        <label for="role">Rôle</label>
        <select class="custom-select" name="role" id="role" aria-describedby="roleHelpBlock">
            <option value=" " selected disabled>Choisir un rôle</option>
            <option value="admin">Admin</option>
            <option value="author">Author</option>
            <option value="superadmin">Super Admin</option>
        </select>
        <small id="roleHelpBlock" class="form-text text-muted">
            Le rôle de l'utilisateur 
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Ajouter</button>
</form>