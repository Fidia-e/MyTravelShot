<br>
<table class="table table-hover mt-4">
  <tbody>
    <?php foreach ($authors as $author) : ?>
      <div class="col-xs-12 col-sm-6 col-md-3">
        <div class="sol">
          <div class="carte-auteur">
            <div class=" text-center">
              <ul class="list-inline">
              <h3><strong><?= $author->getUsername(); ?></></h3>
                <li>
                  <h4>de la lointaine contrée de : <br><strong><?= $author->getCity(); ?></strong></h4>
                </li>
                <li>
                  <p>Pays : <strong><?= $author->getCountry(); ?></strong></p>
                </li>
                <br>
                <h4>Ses photos: </h4>
                <li>
                  <a class="gallery" href="<?= $router->generate('shot-browseByAuthor', ['author_id' => $author->getId()]) ?>" data-toggle="tooltip" data-original-title="">
                  <i class="fa fa-camera eyeAuteur"></i>
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