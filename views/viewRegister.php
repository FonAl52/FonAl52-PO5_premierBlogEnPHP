<section class="comment-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-0"></div>
			<div class="col-lg-8 col-md-12">
				<div class="comment-form">
					<form method="post" action="user&create" class="contact1-form validate-form">
						<div class="row">
							<div class="col-sm-6">
								<input type="text" aria-required="true" minlength="3" name="firstName" class="form-control"
									placeholder="Entrez votre prénom" aria-invalid="true" required>
							</div>
							<div class="col-sm-6">
								<input type="text" aria-required="true" minlength="3" name="lastName" class="form-control"
									placeholder="Entrez votre nom" aria-invalid="true" required>
							</div>
							<div class="col-sm-12">
								<input type="email" aria-required="true" name="email" class="form-control"
									placeholder="Entrez votre email" aria-invalid="true" required>
									<b class="text-danger"><?php if (isset($errors['email'])) echo $errors['email'] ?></b>
							</div>
							<div class="col-sm-6">
								<input type="password" aria-required="true" minlength="6" name="password" class="form-control"
									placeholder="Entrez votre mot de passe" aria-invalid="true" required>
								<b class="text-danger gras"><?php if (isset($errors['password'])) echo $errors['password'] ?></b>
							</div>
							<div class="col-sm-6">
								<input type="password" aria-required="true" minlength="6" name="confirmPassword" class="form-control"
									placeholder="Confirmation du mot de passe" aria-invalid="true" required>
							</div>
							<div class="col-sm-12 center-text">
								<button class="submit-btn" type="submit" id="form-submit"><b>INSCRIPTION</b></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>