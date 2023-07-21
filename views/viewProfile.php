<section class="profile-section">
    <div class="container-fluid">
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="comment-form">
                        <div class="alert-info" role="alert"><?= htmlspecialchars($_SESSION['message']); ?></div>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-2 col-md-0"></div>
            <div class="profile-content col-12 col-md-10 mx-auto">
                <div class="col-sm-6">
                    <?php if (isset($_GET['editProfilePicture'])) : ?>
                        <div class="comment-form">
                            <form method="post" action="user&changeProfilePicture" class="contact1-form validate-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="form-label" for="profilePicture">Profile Picture:</label>
                                        <input type="file" name="profilePicture" accept="image/*" required>
                                    </div>
                                    <div class="col-sm-12 center-text">
                                        <button class="submit-btn" type="submit"><b>Enregistrer</b></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php else : ?>
                        <div class="profile-picture">
                            <?php if (isset($_SESSION['picture']) && $_SESSION['picture'] !== '') : ?>
                                <img src="<?= htmlspecialchars($_SESSION['picture']); ?>" alt="Profile Picture">
                            <?php else : ?>
                                <img src="public/images/userProfilePicturePlaceholder.jpg" alt="Profile Picture">
                            <?php endif; ?>
                            <div class="edit-profile-icon" data-toggle="tooltip" data-placement="top" title="Modifier">
                                <a href="user&editProfilePicture"><i class="fa-solid fa-camera"></i></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-sm-12">
                    <div class="profile-info">
                        <h2><?= htmlspecialchars($_SESSION['name']); ?></h2>
                        <div class="info-row">
                            <?php if (isset($_GET['editEmail'])) : ?>
                                <div class="comment-form">
                                    <form method="post" action="user&changeEmail" class="contact1-form validate-form">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="form-label" for="email">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email']); ?>" required>
                                            </div>
                                            <div class="col-sm-12 center-text">
                                                <button class="submit-btn" type="submit"><b>Enregistrer</b></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php else : ?>
                                <div class="info-label">Email:</div>
                                <div class="info-value"><?= htmlspecialchars($_SESSION['email']); ?></div>
                                <div class="edit-icon" data-toggle="tooltip" data-placement="top" title="Modifier">
                                    <a href="user&editEmail"><i class="fa-solid fa-pencil"></i></a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="info-row">
                            <?php if (isset($_GET['editLastName'])) : ?>
                                <div class="comment-form">
                                    <form method="post" action="user&changeLastName" class="contact1-form validate-form">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="form-label" for="lastName">Nom:</label>
                                                <input type="lastName" class="form-control" id="lastName" name="lastName" value="<?= htmlspecialchars($_SESSION['lastName']); ?>" required>
                                            </div>
                                            <div class="col-sm-12 center-text">
                                                <button class="submit-btn" type="submit"><b>Enregistrer</b></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php else : ?>
                                <div class="info-label">Nom:</div>
                                <div class="info-value"><?= htmlspecialchars($_SESSION['lastName']); ?></div>
                                <div class="edit-icon" data-toggle="tooltip" data-placement="top" title="Modifier">
                                    <a href="user&editLastName"><i class="fa-solid fa-pencil"></i></a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="info-row">
                            <?php if (isset($_GET['editFirstName'])) : ?>
                                <div class="comment-form">
                                    <form method="post" action="user&changeFirstName" class="contact1-form validate-form">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="form-label" for="firstName">Prénom:</label>
                                                <input type="firstName" class="form-control" id="firstName" name="firstName" value="<?= htmlspecialchars($_SESSION['firstName']); ?>" required>
                                            </div>
                                            <div class="col-sm-12 center-text">
                                                <button class="submit-btn" type="submit"><b>Enregistrer</b></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php else : ?>
                                <div class="info-label">Prénom:</div>
                                <div class="info-value"><?= htmlspecialchars($_SESSION['firstName']); ?></div>
                                <div class="edit-icon" data-toggle="tooltip" data-placement="top" title="Modifier">
                                    <a href="user&editFirstName"><i class="fa-solid fa-pencil"></i></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
