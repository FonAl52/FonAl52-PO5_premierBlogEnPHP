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
				<section id="users-section">
					<div class="row">
						<!-- Code pour afficher les utilisateurs -->
						<?php foreach ($users as $user) : ?>
							<div class="col-lg-4 col-md-6">
								<div class="card h-100">
									<div class="single-post post-style-1">
										<div class="blog-image p-1">
											<?php if ($user->getPicture()) : ?>
												<img src="<?= htmlspecialchars($user->getPicture()) ?>" alt="">
											<?php else : ?>
												<img src="public/images/userProfilePicturePlaceholder.jpg" alt="Profile Picture">
											<?php endif; ?>
										</div>
										<div class="blog-image mt-3"><?= htmlspecialchars($user->getFirstName(), " ") ?> <?= htmlspecialchars($user->getLastName()) ?></div>
									</div><!-- single-post -->
								</div><!-- card -->
								<div class="managment-action users">
									<ul>
										<?php if ($user->getRole() == 3) : ?>
											<li><a href="admin&userUnlock&id=<?= htmlspecialchars($user->getId()) ?>"><i class="fa-solid fa-lock"></i></a></li>
										<?php else : ?>
											<li><a href="admin&userLock&id=<?= htmlspecialchars($user->getId()) ?>"><i class="fa-solid fa-unlock"></i></a></li>
										<?php endif; ?>
										<li><a href="admin&userDelete&id=<?= htmlspecialchars($user->getId()) ?>" onclick="return confirm('Voulez-vous supprimer définitivement cet utilisateur ?')"><i class="fa-solid fa-trash"></i></i></a></li>
										<?php if ($user->getRole() == 1) : ?>
											<li><a href="admin&userNorole&id=<?= htmlspecialchars($user->getId()) ?>"><i class="fa-solid fa-star"></i></a></li>
										<?php else : ?>
											<li><a href="admin&userAdmin&id=<?= htmlspecialchars($user->getId()) ?>"><i class="fa-solid fa-screwdriver-wrench"></i></a></li>
										<?php endif; ?>
									</ul>
								</div>
							</div><!-- col-lg-4 col-md-6 -->
						<?php endforeach; ?>
					</div>
				</section>
			</main>
		</div>
	</div>
</section>