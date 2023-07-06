<section class="post-section">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 text-center">
                <div class="comment-form">
                    <?php if (isset($_SESSION['message'])) : ?>
                        <div class="alert alert-success"><?= $_SESSION['message']; ?></div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
                    <?php if (isset($errors['errors'])) : ?>
                        <div class="alert"><?= $errors['errors']; ?></div>
                        <?php unset($errors['errors']); ?>
                    <?php endif; ?>
                    <form method="post" action="post&updateTitle&id=<?= $post[0]->getId() ?>" class="contact1-form validate-form mb-3" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="title">Titre de l'article:</label>
                                    <input type="text" id="title" aria-required="true" minlength="3" name="title" class="form-control" placeholder="Titre de l'article" aria-invalid="true" required>
                                    <button class="submit-btn" type="submit" name="submitTitle"><b>Modifier le titre</b></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form method="post" action="post&updateCategory&id=<?= $post[0]->getId() ?>" class="contact1-form validate-form mb-3" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="categoryId">Catégorie de l'article:</label>
                                    <select name="categoryId" id="categoryId" class="form-control">
                                        <option value="">-- Sélectionner une catégorie --</option>
                                        <!-- Loop to display the categories stored in the database -->
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category->getIdCategory(); ?>"><?= $category->getName(); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="submit-btn" type="submit" name="submitCategory"><b>Modifier la catégorie</b></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form method="post" action="post&updateChapo&id=<?= $post[0]->getId() ?>" class="contact1-form validate-form mb-3" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="chapo">Chapo de l'article:</label>
                                    <textarea id="chapo" name="chapo" class="form-control" placeholder="Chapo de l'article" aria-required="true" aria-invalid="true" required></textarea>
                                    <button class="submit-btn" type="submit" name="submitChapo"><b>Modifier le chapo</b></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form method="post" action="post&updatePicture&id=<?= $post[0]->getId() ?>" class="contact1-form validate-form mb-3" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="picture">Image de l'article:</label>
                                    <input type="file" id="picture" name="picture" class="form-control-file">
                                    <button class="submit-btn" type="submit" name="submitPicture"><b>Modifier l'image</b></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form method="post" action="post&updateContent&id=<?= $post[0]->getId() ?>" class="contact1-form validate-form mb-3" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="content">Contenu de l'article:</label>
                                    <textarea id="content" name="content" class="form-control" placeholder="Contenu de l'article" aria-required="true" aria-invalid="true" required></textarea>
                                    <button class="submit-btn" type="submit" name="submitContent"><b>Modifier le contenu</b></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>