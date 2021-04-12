<div class="container my-4">
<br>
<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification d'un utilisateur</h2>

<form action="<?= $router->generate('user-update', ['id' => $user->getId()]) ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="#">

    <div class="form-group">
        <label for="name">Prénom</label>
        <input type="text" class="form-control" value="<?= $user->getFirstname() ?>" name="firstname" id="firstname" placeholder="Prénom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" value="<?= $user->getLastname() ?>" name="lastname" id="lastname" placeholder="Nom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="name">Email</label>
        <input type="text" class="form-control" value="<?= $user->getEmail() ?>" name="email" id="email" placeholder="Email de l'utilisateur">
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

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>