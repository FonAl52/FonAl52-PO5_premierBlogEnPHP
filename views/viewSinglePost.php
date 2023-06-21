<section id="single-post" class="blog-area section">
  <div class="container">
    <div class="single-post post-style-2">
      <div class="post-row">
        <?php
        if (isset($_SESSION['message'])) {
          echo '<div class="success-message">' . $_SESSION['message'] . '</div>';
          unset($_SESSION['message']);
        }
        ?>
      </div>
    </div>
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
          $authorName = 'Unknown';
          $authorImage = 'public/images/userProfilePicturePlaceholder.jpg';

          foreach ($users as $user) {

            if ($user->getId() == $post[0]->getUserId()) {
              $authorName = $user->getFirstName() . ' ' . $user->getLastName();
              $authorImage = $user->getPicture();
              break;
            }
          }
          ?>

          <p class="avatar mt-4">
            <img src="<?= $authorImage ?>" alt="Profile Image">
          </p>
          <div class="blog-info">
            <p><strong>Auteur:</strong> <?= $authorName ?></p>
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
    <!-- Affichage des commentaires -->
    <div class="comment single-post post-style-2">
      <!-- Affichage du post -->

      <!-- Affichage des commentaires -->
      <?php foreach ($comments as $comment) : ?>
        <?php
        $commentAuthorName = 'Unknown';
        $commentAuthorImage = '/public/images/userProfilePicturePlaceholder.jpg';

        foreach ($users as $user) {

          if ($user->getId() == $comment->getUserId()) {
            $commentAuthorName = $user->getFirstName() . ' ' . $user->getLastName();
            $commentAuthorImage = $user->getPicture();
            break;
          }
        }
        ?>
        <div class="comment-row single-post post-style-2">
          <p class="avatar mt-4">
            <img src="<?= $commentAuthorImage ?>" alt="Profile Image">
          </p>
          <p><strong>Auteur:</strong> <?= $commentAuthorName ?></p>
          <p class="para m-4"><?= $comment->getComment() ?></p>
          <ul class="m-4">
            <?php if ($comment->getCreatedAt() === $comment->getUpdatedAt() && !empty($comment->getUpdatedAt())) : ?>
              <li>Dernière modification : <?= $comment->getUpdatedAt() ?></li>
            <?php else : ?>
              <li>Date de mise en ligne : <?= $comment->getCreatedAt() ?></li>
            <?php endif; ?>

          </ul>
        </div>
      <?php endforeach; ?>
    </div><!-- container -->

    <?php if (isset($_SESSION['id'])) { ?>
      <form class="comment-form" action="comment&create" method="POST">
        <input type="hidden" name="postId" value="<?= $post[0]->getId() ?>">
        <input type="hidden" name="userId" value="<?= $_SESSION['id'] ?>">

        <div class="form-group">
          <label for="comment">Ajouter un nouveau commentaire</label>
          <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    <?php } else { ?>
      <div class="single-post post-style-2">
        <div class="post-row">
          <p><strong>Pour ajouter un commentaire merci de vous connecter ou de vous inscrire</strong></p>
        </div>
        <div class="post-row">
          <a href="user&connect">Se connecter</a>
        </div>
        <div class="post-row">
          <a href="user&register">S’inscrire</a>
        </div>
      </div>
    <?php } ?>
</section><!-- section -->