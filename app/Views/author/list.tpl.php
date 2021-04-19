<div class="container my-4">
<br>
<a href="<?= $router->generate('author-add') ?>" class="btn btn-success float-right">Ajouter</a>
<h2>Liste des auteurs</h2>
<table class="table table-hover mt-4">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Pseudo</th>
            <th scope="col">Ville</th>
            <th scope="col">Pays</th>
            <th scope="col">Identifiant utilisateur</th>
            <th scope="col">Nom & prénom utilisateur</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($authors as $author): ?>
            <tr>
                <th scope="col"><?= $author->getId() ?></th>
                <td><?= $author->getUsername() ?></td>
                <td><?= $author->getCity() ?></td>
                <td><?= $author->getCountry() ?></td>
                <td><?= $author->getUserId() ?></td>
                <?php foreach($users as $user): ?>
                    <td><?= $user->getFirstname() ?></td>
                    <td><?= $user->getLastname() ?></td>
                <?php endforeach; ?>
                <td></td>
                <td class="text-right">
                    <a href="<?= $router->generate('author-edit', ['id' => $author->getId()]) ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('author-delete', ['id' => $author->getId()]) ?>?token=<?= $token ?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Euh finalement non</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
       
    </tbody>
</table>