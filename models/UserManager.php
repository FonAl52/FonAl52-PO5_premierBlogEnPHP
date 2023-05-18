<?php

/**
 *
 */
class UserManager extends Model
{

  //gréer la fonction qui va recuperer
  //tous les posts dans la bdd


  public function createUser($user)
  {
    if (!($user instanceof User)) {
      // Retourner une erreur ou une exception
      return false;
    }
    return $this->createOne('user', $user);
  }

  private function createOne($table, $obj)
  {
    $this->getBdd();
    $req = self::$bdd->prepare("INSERT INTO " . $table . " (firstName, lastName, email, age, password, phone, picture, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $req->execute(array(
      $obj->getFirstName(),
      $obj->getLastName(),
      $obj->getEmail(),
      $obj->getAge(),
      md5($obj->getPassword()),
      $obj->getPhone(),
      $obj->getPicture(),
      $obj->getRole()
    ));
    $req->closeCursor();
    return true;
  }
  
  public function getUserByEmail($email)
  {
    $this->getBdd();
    $req = self::$bdd->prepare('SELECT * FROM user WHERE email = ?');
    $req->execute(array($email));
    $user = $req->fetch(PDO::FETCH_ASSOC);

    return $user;
  }
}
