<section class="blog-area section">
	<div class="container">
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
							<div class="blog-image"><img src="<?= $post['picture'] ?>" alt="Blog Image"></div>
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
		</div><!-- row -->
		<a class="load-more-btn" href="post&viewAll"><b>VOIR PLUS</b></a>
	</div><!-- container -->
</section><!-- section -->