<section class="comment-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-0"></div>
			<div class="col-lg-8 col-md-12">
				<div class="comment-form">
					<form method="post" action="service&send" class="contact1-form validate-form">
						<div class="row">
							<div class="col-sm-6">
								<input type="text" aria-required="true" minlength="3" name="firstName" class="form-control" placeholder="Votre nom" aria-invalid="true" required>
							</div>
							<div class="col-sm-6">
								<input type="email" aria-required="true" name="email" class="form-control" placeholder="Votre email" aria-invalid="true" required>
								<b class="text-danger"><?= (isset($errors['email']) === true) ? htmlspecialchars($errors['email']) : ''; ?></b>
							</div>
							<div class="col-sm-12">
								<input type="text" aria-required="true" minlength="3" name="subject" class="form-control" placeholder="Objet du message" aria-invalid="true" required>
							</div>
							<div class="col-sm-12">
								<textarea name="message" class="form-control" placeholder="Votre message" aria-required="true" aria-invalid="true" required></textarea>
							</div>
							<div class="col-sm-12 center-text">
								<button class="submit-btn" type="submit" id="form-submit"><b>Envoyer</b></button>
								<b class="text-success"><?= (isset($success['message']) === true) ? htmlspecialchars($success['message']) : ''; ?></b>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>