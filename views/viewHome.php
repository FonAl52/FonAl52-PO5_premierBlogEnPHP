<section class="blog-area section">
	<div class="container">
	<h1 class="title">Bienvenue sur le blog de Allan Fontaine</h1>
		<div class="row">
			<?php
				$postCount = 0;
					foreach ($posts as $post) :
						if ($postCount >= 3) {
							break;
						}
				$postCount++;
			?>
				<div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">
							<div class="blog-image"><img src="<?= htmlspecialchars($post['picture']) ?>" alt="Blog Image"></div>
								<!-- User picture profile & name display -->
								<?php
									$authorName = 'Unknown';
									$authorImage = 'public/images/default-avatar.jpg';
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
								<h4 class="title"><a href="post&id=<?= htmlspecialchars($post['id']) ?>"><b><?= htmlspecialchars($post['title']) ?></b></a></h4>
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
								<p><strong>Categorie:</strong> <?=htmlspecialchars($categoryName) ?></p>
								<p><strong>Auteur:</strong> <?= htmlspecialchars($authorName) ?></p>
							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
				</div><!-- col-lg-4 col-md-6 -->
			<?php endforeach; ?>
		</div><!-- row -->
		<a class="load-more-btn" href="post&viewAll"><b>VOIR PLUS</b></a>
	</div><!-- container -->
</section><!-- section -->