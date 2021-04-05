<div class="tab-content">
   <div id="category1" class="tab-pane active" >
      <div class="row popup-gallery">


        <?php foreach ($shotByAuthor as $shot) : ?>
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
                      <li>
                        <a href="#" data-toggle="tooltip" data-original-title="Click if you like it">
                          <i class="fa fa-heart"></i>
                        </a>
                      </li>
                      <li>
                        <a href="#" data-toggle="tooltip" data-original-title="Download">
                          <i class="fa fa-download"></i>
                        </a>
                      </li>
                      <li>
                        <a href="#" data-toggle="tooltip" data-original-title="More information">
                          <i class="fa fa-info"></i>
                        </a>
                      </li>
                    </ul>
                    <h3><?= $shot->getTitle(); ?></h3>
                    <p><?= $shot->getDescription(); ?></p>
                  </div>
              </div>
            </div>
          </div> 
        <?php endforeach; ?>


      </div>
   </div>
</div>