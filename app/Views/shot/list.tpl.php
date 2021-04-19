<div class="container my-4">
<br>
<a href="<?= $router->generate('shot-add') ?>" class="btn btn-success float-right">Ajouter</a>
<h2>Liste des publications</h2>
<table class="table table-hover mt-4 w-auto">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Titre</th>
            <th scope="col">Photo</th>
            <th scope="col">Description</th>
            <th scope="col">Identifiant auteur</th>
            <th scope="col">Pseudo auteur</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($shots as $shot): ?>
            <tr class="shotsList">
                <th scope="row"><?= $shot->getId() ?></th>
                <td><?= $shot->getTitle() ?></td>
                <td style="word-wrap: break-word; max-width: 400px"><?= $shot->getPicture() ?></td>
                <td><?= $shot->getDescription() ?></td>
                <td><?= $shot->getAuthorId() ?></td>
                <td class="text-right">
                    <a href="<?= $router->generate('shot-edit', ['id' => $shot->getId()]) ?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('shot-delete', ['id' => $shot->getId()]) ?>?token=<?= $token ?>">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Euh finalement non</a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
       
    </tbody>
</table>