<div class="container my-4">
<br>
<br>
<br>
<h1>Mes informations personnelles</h1>
<br>
<br>
<br>
<table class="table">
  <tbody>
    <tr>
      <th>Prénom</th>
      <td><?= $_SESSION['currentUser']->getFirstname() ?></td>
    </tr>
    <tr>
      <th>Nom</th>
      <td><?= $_SESSION['currentUser']->getLastname() ?></td>
    </tr>
    <tr>
      <th>Email</th>
      <td><?= $_SESSION['currentUser']->getEmail() ?></td>
    </tr>
    <tr>
      <th>Rôle</th>
      <td><?= $_SESSION['currentUser']->getRole() ?></td>
    </tr>
  </tbody>
</table>
<br>
<br>
  <a href="<?= $router->generate('user-editprofil', [$_SESSION['currentUser']->getId()]) ?>" class="btn btn-sm btn-warning">
      <i class="fa fa-pencil-square-o" aria-hidden="true">  Modifier mes informations</i>
  </a>