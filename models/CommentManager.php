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

  public function createComment($comment)
  {
    
    if (!($comment instanceof Comment)) {
      // Retourner une erreur ou une exception
      return false;
    }
    
    return $this->createOne('comment', $comment);
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
    $this->getBdd();
    $var = [];

    $req = self::$bdd->prepare("SELECT id, postId, userId, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM " . $table . " WHERE postId = ?");
    $req->execute(array($postId));
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

    $req = self::$bdd->prepare("SELECT * FROM comment WHERE postId = ? ORDER BY id desc");

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


  public function createOne($table, $obj)
{
    $this->getBdd();
    $req = self::$bdd->prepare("INSERT INTO " . $table . " (postId, userId, comment, validated, createdAt, updatedAt) VALUES (?, ?, ?, 0, NOW(), NOW())");
    $req->execute(array(
        $obj->getPostId(),
        $obj->getUserId(),
        $obj->getComment(),
    ));
    $req->closeCursor();
    return true;
}
}
