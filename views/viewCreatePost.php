<section class="comment-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-0"></div>
      <div class="col-lg-8 col-md-12">
        <div class="comment-form"><?php if (isset($errors) && !empty($errors)) : ?>
            <div class="col-sm-12 center-text">
              <div class="alert alert-danger">
                <ul>
                  <?php foreach ($errors as $error) : ?>
                    <li><?= $error; ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endif; ?>
          <form method="post" action="post&new" class="contact1-form validate-form" enctype="multipart/form-data">
            <div class="row">
              <div class="col-sm-12">
                <input type="text" aria-required="true" minlength="3" name="title" class="form-control" placeholder="Titre de l'article" aria-invalid="true" required>
              </div>
              <div class="col-sm-12">
                <select name="categoryId" class="form-control">
                  <option value="">-- Sélectionner une catégorie --</option>
                  <!-- Loop to display the categories stored in the database -->
                  <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->getIdCategory(); ?>"><?= $category->getName(); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-sm-12">
                <textarea name="chapo" class="form-control" placeholder="Chapo de l'article" aria-required="true" aria-invalid="true" required></textarea>
              </div>
              <div class="col-sm-12">
                <label for="picture">Image de l'article :</label>
                <input type="file" name="picture" id="picture" class="form-control-file">
              </div>
              <div class="col-sm-12">
                <textarea name="content" class="form-control" placeholder="Contenu de l'article" aria-required="true" aria-invalid="true" required></textarea>
              </div>
              <div class="col-sm-12 center-text">
                <button class="submit-btn" type="submit" id="form-submit"><b>Créer l'article</b></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>