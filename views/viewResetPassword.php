<section class="comment-section">
    <div class="container">
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="row">
                <div class="col-lg-4 col-md-0"></div>
                <div class="col-lg-4 col-md-12">
                    <div class="comment-form">
                        <div class="alert-info" role="alert"><?php echo $_SESSION['message'] ?> </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($_SESSION['id']) { ?>
            <div class="row">
                <div class="col-lg-3 col-md-0"></div>
                <div class="col-lg-6 col-md-12">
                    <div class="comment-form">
                        <form method="post" action="user&changePassword" class="contact1-form validate-form" id="password-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="password" aria-required="true" minlength="6" name="new_password" class="form-control" placeholder="Nouveau mot de passe" aria-invalid="true" required>
                                    <b class="text-danger"><?php if (isset($errors['new_password'])) echo $errors['new_password'] ?></b>
                                </div>
                                <div class="col-sm-12">
                                    <input type="password" aria-required="true" minlength="6" name="confirm_password" class="form-control" placeholder="Confirmer le nouveau mot de passe" aria-invalid="true" required>
                                    <b class="text-danger"><?php if (isset($errors['confirm_password'])) echo $errors['confirm_password'] ?></b>
                                </div>
                                <div class="col-sm-12 center-text">
                                    <button class="submit-btn" type="submit" id="form-submit-password"><b>Réinitialiser le mot de passe</b></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-3 col-md-0"></div>
                <div class="col-lg-6 col-md-12">
                    <div class="comment-form">
                        <form method="post" action="user&verifyEmail" class="contact1-form validate-form" id="email-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="email" aria-required="true" name="email" class="form-control" placeholder="Entrez votre email" aria-invalid="true" required>
                                    <b class="text-danger"><?php if (isset($_SESSION['email'])) echo $_SESSION['email'] ?></b>
                                </div>
                                <div class="col-sm-12 center-text">
                                    <button class="submit-btn" type="submit" id="form-submit-email"><b>Vérifier l'email</b></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        <b class="text-danger"><?php if (isset($errors['nom_de_l_erreur'])) echo $errors['nom_de_l_erreur'] ?></b>
    </div>
</section>