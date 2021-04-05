
<h2>Liste des auteurs</h2>
<table class="table table-hover mt-4">
  <tbody>
    <?php foreach ($authors as $author) : ?>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="sol">
          <div class="carte-auteur">
            <div class=" text-center">
              <ul class="list-inline">
              <h3><?= $author->getUsername(); ?></h3>
                <li>
                  <h4><?= $author->getCity(); ?></h4>
                </li>
                <li>
                  <p><?= $author->getCountry(); ?></p>
                </li>
                <li>
                  <a class="gallery" href="<?= $router->generate('shot-browseByAuthor', ['author_id' => $author->getId()]) ?>" data-toggle="tooltip" data-original-title="">
                    Voir ses photos
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div> 
    <?php endforeach; ?>
  </tbody>
</table>