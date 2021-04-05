<a href="#" class="btn btn-success float-right">Retour</a>

<h2>Ajouter un utilisateur</h2>
<form action="<?= $router->generate('user-create') ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $token ?>">
  
    <div class="form-group">
        <label for="lastname">Nom</label>
        <input value=" " type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="firstname">Prénom</label>
        <input value=" " type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input value=" " type="email" class="form-control" name="email" id="email" placeholder="Email de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe de l'utilisateur">
    </div>  
    <div class="form-group">
        <label for="email">Ville</label>
        <input value=" " type="email" class="form-control" name="email" id="email" placeholder="Ville de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="password">Pays</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Pays de l'utilisateur">
    </div>  
    <div class="form-group">
        <label for="role">Rôle</label>
        <select class="custom-select" name="role" id="role" aria-describedby="roleHelpBlock">
            <option value="" selected disabled>Choisir un rôle</option>
            <option value=" ">Admin</option>
            <option value=" ">Author</option>
        </select>
        <small id="roleHelpBlock" class="form-text text-muted">
            Le rôle de l'utilisateur 
        </small>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Ajouter</button>
</form>