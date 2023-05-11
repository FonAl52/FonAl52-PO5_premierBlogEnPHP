<?php
require_once 'views/View.php';

class ControllerPost

{
  private $view;

  public function __construct()
  {
    if (isset($url) && count($url) < 1) {
      throw new \Exception("Page Introuvable");
    }
    elseif (isset($_GET['home'])) {
      $this->home();
    }
  }
  public function home(){
    // $this->_postManager = new PostManager();
    // $posts = $this->_postManager->getPosts();
    $this->view = new View('Home');
    $this->view->generate(array());
  }

    

}

 ?>
