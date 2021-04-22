<?php if(isset($_SESSION['currentUser'])) : ?>
<br>
    <p class="display-4">
      <h1 class="bonjour"> Hello <?php echo $_SESSION['currentUser']->getFirstname() ?> !</h1>
    </p>
<?php endif; ?>
<br>

<div class="tab-content">
   <div id="category1" class="tab-pane active" >
      <div class="row popup-gallery">
        <?php foreach ($shots as $shot) : ?>
          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="sol">
              <img class="img-responsive" src="<?= $shot->getPicture(); ?>" alt="First category picture">
              <div class="behind">
                  <div class="head text-center">
                    <ul class="list-inline">
                      <li>
                        <a class="gallery" href="<?= $shot->getPicture(); ?>" data-toggle="tooltip" data-original-title="Quick View">
                          <i class="fa fa-eye"></i>
                        </a>
                      </li>
                    </ul>
                    <h3><?= $shot->getTitle(); ?></h3>
                    <p><?= $shot->getDescription(); ?></p>
                    <br>
                    <br>
                    <h4>par<br><br><strong><?= $authors[$shot->getId()]->getUsername(); ?></strong></h4>
                  </div>
              </div>
            </div>
          </div> 
        <?php endforeach; ?>
      </div>
   </div>
</div>