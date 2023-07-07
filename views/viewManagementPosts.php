<section id="notifications">
	<?php if (isset($_SESSION['error_message'])) : ?>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="comment-form">
					<div class="alert alert-danger">
						<?php echo htmlspecialchars($_SESSION['error_message']); ?>
					</div>
				</div>
			</div>
		</div>
		<?php unset($_SESSION['error_message']); ?>
	<?php endif; ?>
	<?php if (isset($_SESSION['success_message'])) : ?>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="comment-form">
					<div class="alert alert-success">
						<?php echo htmlspecialchars($_SESSION['success_message']); ?>
					</div>
				</div>
			</div>
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
				<section id="articles-section">
					<div class="row">
						<?php foreach ($posts as $post) : ?>
							<div class="col-lg-4 col-md-6">
								<div class="card h-100">
									<div class="single-post post-style-1">
										<div class="blog-image"><img src="<?= htmlspecialchars($post['picture']) ?>" alt="Blog Image"></div>
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
										<a class="avatar" href="#"><img src="<?= htmlspecialchars($authorImage) ?>" alt="Profile Image"></a>
										<div class="blog-info">
											<ul class="post-header">
												<?php if ($post['createdAt'] === $post['updatedAt']) : ?>
													<li>Date de mise en ligne : <?= htmlspecialchars($post['createdAt']) ?></li>
												<?php else : ?>
													<li>Dernière modification : <?= htmlspecialchars($post['updatedAt']) ?></li>
												<?php endif; ?>
											</ul>
											<h4 class="title"><b><?= htmlspecialchars($post['title']) ?></b></h4>
											<p class="para"><?= htmlspecialchars($post['chapo']) ?></p>
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
											<p><strong>Categorie:</strong> <?= htmlspecialchars($categoryName) ?></p>
											<p><strong>Auteur:</strong> <?= htmlspecialchars($authorName) ?></p>
										</div><!-- blog-info -->
									</div><!-- single-post -->
									<div class="managment-action posts">
										<ul>
											<li><a href="post&editPost&id=<?= htmlspecialchars($post['id']) ?>"><i class="fa-solid fa-pen"></i></a></li>
											<li><a href="admin&postDelete&id=<?= htmlspecialchars($post['id']) ?>" onclick="return confirm('Voulez-vous supprimer définitivement cet article ?')"><i class="fa-solid fa-trash"></i></a></li>
										</ul>
									</div>
								</div><!-- card -->
							</div><!-- col-lg-4 col-md-6 -->
						<?php endforeach; ?>
				</section>
			</main>
		</div>
	</div>
</section>