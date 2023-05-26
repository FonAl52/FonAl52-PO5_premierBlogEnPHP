<?php

/**
 *
 */
class Comment
{

  private $id;
  private $postId;
  private $userId;
  private $comment;
  private $createdAt;
  private $updatedAt;

  public function __construct(array $data){
    $this->hydrate($data);
  }

  //hdratation
  public function hydrate(array $data){
    foreach ($data as $key => $value) {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method)) {
        $this->$method($value);
      }
    }
  }

  //setters

  public function setId($id)
  {
    $id = (int) $id;
    if ($id > 0) {
      $this->id = $id;
    }
  }

  public function setPostId($postId)
  {
    $postId = (int) $postId;
    if ($postId > 0) {
      $this->postId = $postId;
    }
  }

  public function setUserId($userId)
  {
    if (is_string($userId)) {
      $this->userId = $userId;
    }
  }

  public function setComment($comment)
  {
    if (is_string($comment)) {
      $this->comment = $comment;
    }
  }

  public function setCreatedAt($createdAt)
  {
      $this->createdAt = $createdAt;

  }
  public function set($updatedAt)
  {
      $this->updatedAt = $updatedAt;

  }

  //getters
  public function getId()
  {
    return $this->id;
  }
  public function getPostId()
  {
    return $this->postId;
  }

  public function getUserId()
  {
    return $this->userId;
  }

  public function getComment()
  {
    return $this->comment;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

}












 ?>
