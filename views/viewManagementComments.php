<section id="notifications">
	<?php if (isset($_SESSION['error_message'])) : ?>
		<div class="alert alert-danger">
			<?php echo $_SESSION['error_message']; ?>
		</div>
		<?php unset($_SESSION['error_message']); ?>
	<?php endif; ?>

	<?php if (isset($_SESSION['success_message'])) : ?>
		<div class="alert alert-success">
			<?php echo $_SESSION['success_message']; ?>
		</div>
		<?php unset($_SESSION['success_message']); ?>
	<?php endif; ?>
</section>
<section id="admin" class="blog-area section">
	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
				<div class="sidebar-sticky">
					<ul class="nav flex-column">
						<li class="nav-item">
							<a class="nav-link" href="admin&managementUsers">
								<i class="fa-solid fa-users"></i>
								<span>Gestion des utilisateurs</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="admin&managementPosts">
								<i class="fa-solid fa-file"></i>
								<span>Gestion des articles</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="admin&managementComments">
								<i class="fa-solid fa-comments"></i>
								<span>Gestion des commentaires</span>
							</a>
						</li>
					</ul>
				</div>
			</nav>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
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