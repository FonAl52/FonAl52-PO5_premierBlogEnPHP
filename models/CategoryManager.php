<?php

/**
 *
 */
class CategoryManager extends Model
{

  public function getCategories()
  {
    $this->getBdd();
    $req = self::$bdd->query("SELECT * FROM category");
    $categories = [];
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
      $categories[] = new Category($data);
    }
    $req->closeCursor();
    return $categories;
  }
}
