<section id="single-post" class="blog-area section">
  <div class="container">

    <div class="col-lg-12 col-md-12">

      <div class="single-post post-style-2">
        <div class="post-row">
          <div class="info-value">
            <h3><b><?= $post[0]->getTitle() ?></b></h3>
          </div>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) : ?>
            <div class="edit-post title" data-toggle="tooltip" data-placement="top" title="Modifier">
              <a href="post&editTitle"><i class="fa-solid fa-pencil post"></i></a>
            </div>
          <?php endif; ?>
        </div>
      </div><!-- single-post -->

      <div class="single-post post-style-2">
        
          <div class="post-row">
            <div class="blog-image">
              <img src="<?= $post[0]->getPicture() ?>" alt="Blog Image">
            </div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) : ?>
              <div class="edit-post picture" data-toggle="tooltip" data-placement="top" title="Modifier">
                <a href="post&editTitle"><i class="fa-solid fa-pencil post"></i></a>
              </div>
            <?php endif; ?>
          </div>
          <div class="post-header">
          <ul class="m-4">
            <?php if ($post[0]->getCreatedAt() === $post[0]->getUpdatedAt()) : ?>
              <li>Date de mise en ligne : <?= $post[0]->getCreatedAt() ?></li>
            <?php else : ?>
              <li>Dernière modification : <?= $post[0]->getUpdatedAt() ?></li>
            <?php endif; ?>
          </ul>
          <?php
          $authorImage = 'public/images/userProfilePicturePlaceholder.jpg';

          if (!empty($user['picture'])) {
            $authorImage = $user['picture'];
          }
          ?>

          <p class="avatar mt-4">
            <img src="<?= $authorImage ?>" alt="Profile Image">
          </p>
          <div class="blog-info">
            <p><strong>Auteur:</strong> <?= $user['firstName'] . " " . $user['lastName'] ?></p>
            <?php
            $categoryName = 'Unknown';

            foreach ($categories as $category) {
              if ($category->getIdCategory() == $post[0]->getCategoryId()) {
                $categoryName = $category->getName();
                break;
              }
            }
            ?>
            <div class="post-row">
            <p><strong>Categorie:</strong> <?= $categoryName ?></p>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) : ?>
              <div class="edit-post category" data-toggle="tooltip" data-placement="top" title="Modifier">
                <a href="post&editCategory"><i class="fa-solid fa-pencil post"></i></a>
              </div>
            <?php endif; ?>
            </div>

            <div class="post-row">
              <p class="para"><?= $post[0]->getChapo() ?></p>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) : ?>
                <div class="edit-post chapo" data-toggle="tooltip" data-placement="top" title="Modifier">
                  <a href="post&editChapo"><i class="fa-solid fa-pencil post"></i></a>
                </div>
              <?php endif; ?>
            </div>
          </div><!-- blog-info -->
        </div>
      </div><!-- single-post -->
      <div class="single-post post-style-2">
        <div class="post-row">
          <p class="para m-4"><?= $post[0]->getContent() ?></p>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) : ?>
            <div class="edit-post content" data-toggle="tooltip" data-placement="top" title="Modifier">
              <a href="post&editContent"><i class="fa-solid fa-pencil post"></i></a>
            </div>
          <?php endif; ?>
        </div>
      </div><!-- single-post -->
    </div><!-- col-lg-4 col-md-6 -->
  </div><!-- container -->
</section><!-- section -->