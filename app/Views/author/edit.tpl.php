<br>
<a href="<?= $router->generate('author-list') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification d'un auteur</h2>

<form action="#" method="POST" class="mt-5">
    <input type="hidden" name="token" value="#">

    <div class="form-group">
        <label for="name">Pseudo</label>
        <input type="text" class="form-control" value="#" name="name" id="name" placeholder="Pseudo de l'auteur">
    </div>
    <div class="form-group">
        <label for="name">Ville</label>
        <input type="text" class="form-control" value="#" name="name" id="name" placeholder="Ville de l'auteur">
    </div>
    <div class="form-group">
        <label for="name">Pays</label>
        <input type="text" class="form-control" value="#" name="name" id="name" placeholder="Pays de l'auteur">
    </div>
    <div class="form-group">
        <label for="name">Identifiant utilisateur</label>
        <input type="text" class="form-control" value="#" name="name" id="name" placeholder="Numéro identifiant utilisateur">
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>