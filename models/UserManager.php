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
    $req->execute(array($email, md5($password)));
    $user = $req->fetch(PDO::FETCH_ASSOC);
    if ($user) {
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
    if ($user) {
      $this->openSession($user);
    }
    return $user;
  }

  public function getUserById($userId)
  {
    $this->getBdd();
    $req = self::$bdd->prepare('SELECT firstName, lastName, email, age, phone, picture, role FROM user WHERE id = ?');
    $req->execute(array($userId));
    $user = $req->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  public function updateUser($user, $options)
  {
    // var_dump($user);
    // var_dump($options);
    $this->getBdd();
    $set = [];
    $values = [];
    foreach ($options as $key => $value) {
      $set[] = "$key = ?";
      $values[] = $value;
    }
    // var_dump($set);
    // var_dump($values);

    $values[] = $user['id'];
    // var_dump($values);
    $req = self::$bdd->prepare("UPDATE user SET " . implode(", ", $set) . " WHERE id = ?");
    // var_dump($req);die;
    $req->execute($values);
    return $req->rowCount() > 0;
  }

  public function getAllUsers()
  {
    $this->getBdd();
    $req = self::$bdd->query("SELECT id, firstName, lastName, picture, role FROM user");
    $users = [];

    while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
      $users[] = new User($data);
    }

    $req->closeCursor();
    return $users;
  }

  public function updateUserRole($userId, $options)
  {
    $this->getBdd();
    $set = [];
    $values = [];
    foreach ($options as $key => $value) {
      $set[] = "$key = ?";
      $values[] = $value;
    }

    $values[] = $userId; // Ajoute le userId à la fin du tableau des valeurs

    $req = self::$bdd->prepare("UPDATE user SET " . implode(", ", $set) . " WHERE id = ?");
    $req->execute($values);

    return $req->rowCount() > 0;
  }

  public function deleteUser($userId)
  {
    $this->getBdd();
    $req = self::$bdd->prepare("DELETE FROM user WHERE id = ?");
    $req->execute([$userId]);
    return $req->rowCount() > 0;
  }

}
