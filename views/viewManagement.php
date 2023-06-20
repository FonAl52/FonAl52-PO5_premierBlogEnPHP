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
					<div class="row">
						<!-- Code pour afficher les utilisateurs -->
						<?php foreach ($users as $user) : ?>
							<div class="col-lg-4 col-md-6">
								<div class="card h-100">
									<div class="single-post post-style-1">
										<div class="blog-image p-1">
											<?php if ($user->getPicture()) : ?>
												<img src="<?= $user->getPicture() ?>" alt="">
											<?php else : ?>
												<img src="public/images/userProfilePicturePlaceholder.jpg" alt="Profile Picture">
											<?php endif; ?>
										</div>
										<div class="blog-image mt-3"><?= $user->getFirstName(), " " ?> <?= $user->getLastName() ?></div>
									</div><!-- single-post -->
								</div><!-- card -->
								<div class="managment-action users">
									<ul>
										<?php if ($user->getRole() == 3) : ?>
											<li><a href="admin&userUnlock&id=<?= $user->getId() ?>"><i class="fa-solid fa-lock"></i></a></li>
										<?php else : ?>
											<li><a href="admin&userLock&id=<?= $user->getId() ?>"><i class="fa-solid fa-unlock"></i></a></li>
										<?php endif; ?>
										<li><a href="admin&userDelete&id=<?= $user->getId() ?>" onclick="return confirm('Voulez-vous supprimer définitivement cet utilisateur ?')"><i class="fa-solid fa-trash"></i></i></a></li>
										<?php if ($user->getRole() == 1) : ?>
											<li><a href="admin&userNorole&id=<?= $user->getId() ?>"><i class="fa-solid fa-star"></i></a></li>
										<?php else : ?>
											<li><a href="admin&userAdmin&id=<?= $user->getId() ?>"><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
										<?php endif; ?>
									</ul>
								</div>
							</div><!-- col-lg-4 col-md-6 -->
						<?php endforeach; ?>
					</div>
				</section>
				<section id="articles-section">
					<div class="row">
						<?php foreach ($posts as $post) : ?>
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

											<h4 class="title"><b><?= $post['title'] ?></b></h4>

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
									<div class="managment-action posts">
										<ul>
											<li><a href="post&id=<?= $post['id'] ?>"><i class="fa-solid fa-pen"></i></a></li>
											<li><a href="admin&postDelete&id=<?= $post['id'] ?>" onclick="return confirm('Voulez-vous supprimer définitivement cet article ?')"><i class="fa-solid fa-trash"></i></a></li>
										</ul>
									</div>
								</div><!-- card -->
							</div><!-- col-lg-4 col-md-6 -->
						<?php endforeach; ?>
				</section>
				<section id="comments-section">
					<!-- Affichage des commentaires -->
					<div class="row">
						<!-- Affichage du post -->

						<!-- Affichage des commentaires -->
						<?php foreach ($comments as $comment) : ?>
							<?php
							$commentAuthorName = 'Unknown';
							$commentAuthorImage = 'public/images/userProfilePicturePlaceholder.jpg';
							foreach ($posts as $post) {
								if ($comment->getPostId() == $post['id']) {
									$postTitle = $post['title'];
								}
							}

							foreach ($users as $user) {

								if ($user->getId() == $comment->getUserId()) {
									$commentAuthorName = $user->getFirstName() . ' ' . $user->getLastName();
									$commentAuthorImage = $user->getPicture();
									break;
								}
							}

							?>

							<div class="col-lg-4 col-md-6">
								<div class="comment-row single-post post-style-2">
									<h4 class="title"><b><?= $postTitle ?></b></h4>
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
								<div class="managment-action comments">
									<ul>
										<?php if ($comment->getValidated() == 1) : ?>
											<li><a href="admin&commentUnvalidate&id=<?= $comment->getId() ?>"><i class="fa-sharp fa-solid fa-xmark"></i></a></li>
										<?php else : ?>
											<li><a href="admin&commentValidate&id=<?= $comment->getId() ?>"><i class="fa-sharp fa-solid fa-check"></i></a></li>
										<?php endif; ?>
										<li><a href="admin&commentDelete&id=<?= $comment->getId() ?>" onclick="return confirm('Voulez-vous supprimer définitivement ce commentaire ?')"><i class="fa-solid fa-trash"></i></i></a></li>
									</ul>
								</div>
							</div>
						<?php endforeach; ?>
					</div><!-- container -->

				</section>
			</main>
		</div>
	</div>
</section>