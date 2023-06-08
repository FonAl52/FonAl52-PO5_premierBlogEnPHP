<section id="admin" class="blog-area section">
	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
				<div class="sidebar-sticky">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="#users" data-target="users-section">Utilisateurs</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#articles" data-target="articles-section">Articles</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#comments" data-target="comments-section">Commentaires</a>
						</li>
					</ul>
				</div>
			</nav>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
				<section id="users-section">
					<!-- Code pour afficher les utilisateurs -->
					<?php foreach ($users as $user) : ?>
						<div class="col-lg-4 col-md-6">
						<a href="admin&id=<?= $user->getId() ?>"><div class="card h-100">
								<div class="single-post post-style-1">
									<div class="blog-image p-1">
										<?php if ($user->getPicture()) : ?>
											<img src="<?= $user->getPicture() ?>" alt="">
										<?php else : ?>
											<img src="public/images/userProfilePicturePlaceholder.jpg" alt="Profile Picture">
										<?php endif; ?>
									</div>
									<div class="blog-image mt-3"><?= $user->getFirstName() ?></div>
									<div class="blog-image"><?= $user->getLastName() ?></div>
									<div class="blog-content">
										<!-- Afficher d'autres informations sur l'utilisateur ici -->
										<!-- Exemple : -->
										<div class="user-email"><?= $user->getEmail() ?></div>
										<div class="user-age"><?= $user->getAge() ?></div>
										<!-- ... -->
									</div>
								</div><!-- single-post -->
							</div><!-- card --></a>
						</div><!-- col-lg-4 col-md-6 -->
					<?php endforeach; ?>
				</section>
				<section id="articles-section">
				<div class="row">
			<?php foreach ($posts as $post) :?>
				<div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

							<div class="blog-image"><img src="<?= $post['picture'] ?>" alt="Blog Image"></div>

							<!-- User picture profile & name display -->
							<?php
							$authorName = 'Unknown';
							$authorImage = 'public/images/userProfilePicturePlaceholder.jpg';

							foreach ($users as $user) {

								if ($user->getId() == $post['userId']) {
									$authorName = $user->getFirstName() . ' ' . $user->getLastName();
									$authorImage = $user->getPicture();
									break;
								}
							}
							?>

							<a class="avatar" href="#"><img src="<?= $authorImage ?>" alt="Profile Image"></a>

							<div class="blog-info">

								<ul class="post-header">
									<?php if ($post['createdAt'] === $post['updatedAt']) : ?>
										<li>Date de mise en ligne : <?= $post['createdAt'] ?></li>
									<?php else : ?>
										<li>Dernière modification : <?= $post['updatedAt'] ?></li>
									<?php endif; ?>
								</ul>

								<h4 class="title"><a href="post&id=<?= $post['id'] ?>"><b><?= $post['title'] ?></b></a></h4>

								<p class="para"><?= $post['chapo'] ?></p>

								<!-- Category display -->
								<?php
								$categoryName = 'Unknown';
								foreach ($categories as $category) {
									if ($category->getIdCategory() == $post['categoryId']) {
										$categoryName = $category->getName();
										break;
									}
								}
								?>

								<p><strong>Categorie:</strong> <?= $categoryName ?></p>
								<p><strong>Auteur:</strong> <?= $authorName ?></p>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
				</div><!-- col-lg-4 col-md-6 -->
			<?php endforeach; ?>
				</section>
				<section id="comments-section">
					<!-- Affichage des commentaires -->
					<div class="comment single-post post-style-2">
						<!-- Affichage du post -->

						<!-- Affichage des commentaires -->
						<?php foreach ($comments as $comment) : ?>
							<?php
							$commentAuthorName = 'Unknown';
							$commentAuthorImage = 'public/images/userProfilePicturePlaceholder.jpg';

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

				</section>
			</main>
		</div>
	</div>
</section>