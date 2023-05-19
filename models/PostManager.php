<?php

/**
 *
 */
class PostManager extends Model
{

  public function createPost($post)
  {
    if (!($post instanceof Post)) {
      // Retourner une erreur ou une exception
      return false;
    }

    return $this->createOne('post', $post);
  }

  //gréer la fonction qui va recuperer
  //tous les posts dans la bdd
  public function getPosts()
  {
    return $this->getAll('posts', 'Post');
  }

  public function getPost($id)
  {
    return $this->getOne('post', 'Post', $id);
  }

  private function createOne($table, $obj)
  {
    $this->getBdd();

    $req = self::$bdd->prepare("INSERT INTO " . $table . " (categoryId, userId, title, chapo, picture, content) VALUES (?, ?, ?, ?, ?, ?)");
    $req->execute(array(
      $obj->getCategoryId(),
      $obj->getUserId(),
      $obj->getTitle(),
      $obj->getChapo(),
      $obj->getPicture(),
      $obj->getContent(),
    ));
    $req->closeCursor();
    return true;
  }

  private function getOne($table, $obj, $id)
  {
    $this->getBdd();
    $var = [];
    $req = self::$bdd->prepare("SELECT id, categoryId, title, chapo, picture, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM " . $table . " WHERE id = ?");
    $req->execute(array($id));
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
      $var[] = new $obj($data);
    }

    return $var;
    $req->closeCursor();
  }
  
  public function getAll($table)
  {
    $this->getBdd();
    $data = [];
    $req = self::$bdd->prepare('SELECT * FROM ' . $table . ' ORDER BY id DESC');
    $req->execute();

    // On récupère les données directement dans un tableau
    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
      $data[] = $row;
    }

    $req->closeCursor();

    return $data;
  }
}
