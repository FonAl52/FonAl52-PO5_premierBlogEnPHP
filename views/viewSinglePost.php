<section id="single-post" class="blog-area section">
    <div class="container">
        <div class="single-post post-style-2">
            <div class="post-row">
                <?php if (isset($_SESSION['message']) || isset($errors['errors'])) { ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="comment-form">
                                <?php if (isset($_SESSION['message'])) { ?>
                                    <div class="alert-info" role="alert"><?php echo htmlspecialchars($_SESSION['message']) ?></div>
                                <?php } ?>
                                <?php if (isset($errors['errors'])) { ?>
                                    <div class="alert-danger" role="alert"><?php echo htmlspecialchars($errors['errors']) ?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php }
                unset($_SESSION['message']); ?>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="single-post post-style-2">
                <div class="post-row">
                    <div class="info-value">
                        <h3><b><?= htmlspecialchars($post[0]->getTitle()) ?></b></h3>
                    </div>
                </div>
            </div><!-- single-post -->
            <div class="single-post post-style-2">
                <div class="post-row">
                    <div class="blog-image">
                        <img src="<?= htmlspecialchars($post[0]->getPicture()) ?>" alt="Blog Image">
                    </div>
                </div>
                <div class="post-header">
                    <ul class="m-4">
                        <?php if ($post[0]->getCreatedAt() === $post[0]->getUpdatedAt()) : ?>
                            <li>Date de mise en ligne : <?= htmlspecialchars($post[0]->getCreatedAt()) ?></li>
                        <?php else : ?>
                            <li>Dernière modification : <?= htmlspecialchars($post[0]->getUpdatedAt()) ?></li>
                        <?php endif; ?>
                    </ul>
                    <?php
                    $authorName = 'Unknown';
                    foreach ($users as $user) {
                        if ($user->getId() == $post[0]->getUserId()) {
                            $authorName = $user->getFirstName() . ' ' . $user->getLastName();
                            if ($user->getPicture() != NULL) {
                                $authorImage = $user->getPicture();
                            } else {
                                $authorImage = './public/images/userProfilePicturePlaceholder.jpg';
                            }
                            break;
                        }
                    }
                    ?>
                    <p class="avatar mt-4">
                        <img src="<?= htmlspecialchars($authorImage) ?>" alt="Profile Image">
                    </p>
                    <div class="blog-info">
                        <p><strong>Auteur:</strong> <?= htmlspecialchars($authorName) ?></p>
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
                            <p><strong>Categorie:</strong> <?= htmlspecialchars($categoryName) ?></p>
                        </div>
                        <div class="post-row">
                            <p class="para"><?= htmlspecialchars($post[0]->getChapo()) ?></p>
                        </div>
                    </div><!-- blog-info -->
                </div>
            </div><!-- single-post -->
            <div class="single-post post-style-2">
                <div class="post-row">
                    <p class="para m-4"><?= htmlspecialchars($post[0]->getContent()) ?></p>
                </div>
            </div><!-- single-post -->
        </div>
        <!-- Affichage des commentaires -->
        <div class="comment single-post post-style-2">
            <!-- Affichage du post -->
            <!-- Affichage des commentaires -->
            <?php foreach ($comments as $comment) : ?>
                <?php
                $commentAuthorName = 'Unknown';
                foreach ($users as $user) {
                    if ($user->getId() == $comment->getUserId()) {
                        $commentAuthorName = $user->getFirstName() . ' ' . $user->getLastName();
                        if ($user->getPicture() != NULL) {
                            $commentAuthorImage = $user->getPicture();
                        } else {
                            $commentAuthorImage = './public/images/userProfilePicturePlaceholder.jpg';
                        }
                        break;
                    }
                }
                ?>
                <div class="comment-row single-post post-style-2">
                    <p class="avatar mt-4">
                        <img src="<?= htmlspecialchars($commentAuthorImage) ?>" alt="Profile Image">
                    </p>
                    <p><strong>Auteur:</strong> <?= htmlspecialchars($commentAuthorName) ?></p>
                    <p class="para m-4"><?= htmlspecialchars($comment->getComment()) ?></p>
                    <ul class="m-4">
                        <?php if ($comment->getCreatedAt() === $comment->getUpdatedAt() && !empty($comment->getUpdatedAt())) : ?>
                            <li>Dernière modification : <?= htmlspecialchars($comment->getUpdatedAt()) ?></li>
                        <?php else : ?>
                            <li>Date de mise en ligne : <?= htmlspecialchars($comment->getCreatedAt()) ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div><!-- container -->
        <?php if (isset($_SESSION['id'])) { ?>
            <form class="comment-form" action="comment&create" method="POST">
                <input type="hidden" name="postId" value="<?= htmlspecialchars($post[0]->getId()) ?>">
                <input type="hidden" name="userId" value="<?= htmlspecialchars($_SESSION['id']) ?>">

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