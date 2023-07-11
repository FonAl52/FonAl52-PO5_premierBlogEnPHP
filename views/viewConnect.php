<section class="comment-section">
	<div class="container">
		<?php if (isset($_SESSION['message']) === TRUE) { ?>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="comment-form">
						<div class="alert-info" role="alert"><?php htmlspecialchars($_SESSION['message']) ?></div>
					</div>
				</div>
			</div>
		<?php }

		unset($_SESSION['message']); ?>
		<div class="row">
			<div class="col-lg-3 col-md-0"></div>
			<div class="col-lg-6 col-md-12">
				<div class="comment-form">
					<form method="post" action="user&login" class="contact1-form validate-form">
						<div class="row">
							<div class="col-sm-12">
								<input type="email" aria-required="true" name="email" class="form-control" placeholder="Entrez votre email" aria-invalid="true" required>
								<b class="text-danger"><?php if (isset($errors['email'])) htmlspecialchars($errors['email']) ?></b>
							</div>
							<div class="col-sm-12">
								<input type="password" aria-required="true" minlength="6" name="password" class="form-control" placeholder="Entrez votre mot de passe" aria-invalid="true" required>
								<b class="text-danger gras"><?php if (isset($errors['password'])) htmlspecialchars($errors['password']) ?></b>
							</div>
							<div class="col-sm-12 center-text">
								<button class="submit-btn" type="submit" id="form-submit"><b>CONNEXION</b></button>
							</div>
							<div class="col-sm-12 center-text">
								<a href="user&resetPassword">Mot de passe oublié ?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<b class="text-danger"><?php if (isset($errors['nom_de_l_erreur'])) $errors['nom_de_l_erreur'] ?></b>
	</div>
</section>