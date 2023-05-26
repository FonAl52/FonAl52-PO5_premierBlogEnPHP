<?php

/**
 *
 */
class CommentManager extends Model
{

  public function getAll()
  {
    return $this->getAllComment('comment', 'Comment');
  }

  public function getOne($postId)
  {
    return $this->getOneComment('comment', 'Comment', $postId);
  }

  private function getAllComment($table, $obj)
  {
    $this->getBdd();
    $var = [];
    $req = self::$bdd->prepare('SELECT * FROM ' . $table . ' ORDER BY id desc');
    $req->execute();

    //on crée la variable data qui
    //va cobntenir les données
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
      // var contiendra les données sous forme d'objets
      $var[] = new $obj($data);
    }

    $req->closeCursor();
    return $var;
  }

  private function getOneComment($table, $obj, $postId)
  {
    $testbdd = $this->getBdd();
    var_dump($testbdd);
    die;

    $var = [];

    $req = self::$bdd->prepare("SELECT id, postId, userId, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM " . $table . " WHERE postId = ?");
    $test = $req->execute(array($postId));
    var_dump($test);
    die;
    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
      $var[] = new $obj($data);
    }

    $req->closeCursor();
    return $var;
  }

  public function getCommentsByPostId($postId)
  {
    $this->getBdd();
    $comments = [];

    $req = self::$bdd->prepare("SELECT * FROM comment WHERE postId = ?");

    $req->execute([$postId]);

    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
      // Conversion des dates au format français
      $data['createdAt'] = date('d/m/Y à H:i:s', strtotime($data['createdAt']));
      $data['updatedAt'] = date('d/m/Y à H:i:s', strtotime($data['updatedAt']));

      $comments[] = new Comment($data);
    }

    $req->closeCursor();

    return $comments;
  }
}
