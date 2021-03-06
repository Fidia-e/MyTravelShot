<div class="container my-4">
<h1>Bienvenue sur le backoffice</h1>
<br>
<form method="POST" action="<?= $router->generate('admin-authenticate') ?>">
  <div class="form-group">
    <label for="email">Adresse e-mail</label>
    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
    <small id="emailHelp" class="form-text text-muted">Email de connexion</small>
  </div>
  <div class="form-group">
    <label for="password">Mot de passe</label>
    <input type="password" class="form-control" name="password" id="password">
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Connexion</button>
</form>