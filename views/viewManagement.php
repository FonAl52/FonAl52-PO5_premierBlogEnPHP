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
        <div class="row align-items-center justify-content-center" style="min-height: calc(100vh - 200px);">
            <div class="col-md-12 text-center">
                <div class="admin-buttons d-flex align-items-center justify-content-center">
                    <a class="admin-button" href="admin&managementUsers">
                        <i class="fa-solid fa-users"></i>
                        <span>Gestion des utilisateurs</span>
                    </a>
                    <a class="admin-button" href="admin&managementPosts">
                        <i class="fa-solid fa-file"></i>
                        <span>Gestion des articles</span>
                    </a>
                    <a class="admin-button" href="admin&managementComments">
                        <i class="fa-solid fa-comments"></i>
                        <span>Gestion des commentaires</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>