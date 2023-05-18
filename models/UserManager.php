<?php

/**
 *
 */
class UserManager extends Model
{

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

  public function verifyPassword($email, $password)
  {
    $this->getBdd();
    $req = self::$bdd->prepare('SELECT * FROM user WHERE email = ? AND password = ?');
    $req->execute(array($email,md5($password)));
    $user = $req->fetch(PDO::FETCH_ASSOC);
    if($user){
      $this->openSession($user);
    }
    return $user;
  }

  private function openSession($user)
  {
    $_SESSION['id'] = $user['id'];
    $_SESSION['firstName'] = $user['firstName'];
    $_SESSION['lastName'] = $user['lastName'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['age'] = $user['age'];
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['picture'] = $user['picture'];
    $_SESSION['role'] = $user['role'];
  }

  public function changePassword($userId, $newPassword)
  {
    $this->getBdd();
    $req = self::$bdd->prepare('UPDATE user SET password = ? WHERE id = ?');
    $hashedPassword = md5($newPassword);
    $user = $req->execute(array($hashedPassword, $userId));
    if($user){
      $this->openSession($user);
    }
    return $user;
  }
}
