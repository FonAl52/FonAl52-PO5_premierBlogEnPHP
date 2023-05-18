<?php

/**
 *
 */
class Post
{

  private $id;
  private $categoryId;
  private $userId;
  private $title;
  private $chapo;
  private $picture;
  private $content;
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
  public function setCategoryId($categoryId)
  {
    $categoryId = (int) $categoryId;
    if ($categoryId > 0) {
      $this->categoryId = $categoryId;
    }
  }
  public function setUserId($userId)
  {
    $userId = (int) $userId;
    if ($userId > 0) {
      $this->userId = $userId;
    }
  }

  public function setChapo($chapo)
  {
    if (is_string($chapo)) {
      $this->chapo = $chapo;
    }
  }

  public function setPicture($picture)
  {
    if (is_string($picture)) {
      $this->picture = $picture;
    }
  }

  public function setTitle($title)
  {
    if (is_string($title)) {
      $this->title = $title;
    }
  }

  public function setContent($content)
  {
    if (is_string($content)) {
      $this->content = $content;
    }
  }

  public function setCreatedAt($createdAt)
  {
      $this->createdAt = $createdAt;

  }
  public function setUpdatedAt($updatedAt)
  {
      $this->updatedAt = $updatedAt;

  }

  //getters
  public function getId()
  {
    return $this->id;
  }

  public function getCategoryId()
  {
    return $this->categoryId;
  }
  
  public function getUserId()
  {
    return $this->userId;
  }

  public function getChapo()
  {
    return $this->chapo;
  }

  public function getPicture()
  {
    return $this->picture;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getContent()
  {
    return $this->content;
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
