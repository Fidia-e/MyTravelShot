<div class="container my-4">
<br>
<a href="<?= $router->generate('user-showprofil') ?>" class="btn btn-success float-right">Retour</a>
<h2>Modification des informations personnelles</h2>

<form action="<?= $router->generate('user-update', [$_SESSION['currentUser']->getId()]) ?>" method="POST" class="mt-5">
    <input type="hidden" name="token" value="<?= $token ?>">

    <div class="form-group">
        <label for="name">Prénom</label>
        <input type="text" class="form-control" value="<?= $_SESSION['currentUser']->getFirstname() ?>" name="firstname" id="firstname" placeholder="Prénom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" class="form-control" value="<?= $_SESSION['currentUser']->getLAstname() ?>" name="lastname" id="lastname" placeholder="Nom de l'utilisateur">
    </div>
    <div class="form-group">
        <label for="name">Email</label>
        <input type="text" class="form-control" value="<?= $_SESSION['currentUser']->getEmail() ?>" name="email" id="email" placeholder="Email de l'utilisateur">
    </div>

    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>