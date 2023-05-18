<?php

/**
 *
 */
class Category
{

  private $idCategory;
  private $name;

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

  public function setIdCategory($idCategory)
  {
    $idCategory = (int) $idCategory;
    if ($idCategory > 0) {
      $this->idCategory = $idCategory;
    }
  }

  public function setName($name)
  {
    if (is_string($name)) {
      $this->name = $name;
    }
  }

  //getters
  public function getIdCategory()
  {
    return $this->idCategory;
  }

  public function getName()
  {
    return $this->name;
  }

}












 ?>
