<?php

abstract class Model
{

  protected static $bdd;

  //connexion a la bdd

  private static function setBdd(){
    self::$bdd = new PDO('mysql:host=localhost;port=8889;dbname=P05_blog;charset=utf8', 'root', 'root');

    //on utilise les constantes de PDO pour gérer les erreurs
    self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }

  //fonction de connexion par defaut a la bdd
  protected function getBdd(){
    if (self::$bdd == null) {
      self::setBdd();
      return self::$bdd;
    }
  }
}

 ?>
