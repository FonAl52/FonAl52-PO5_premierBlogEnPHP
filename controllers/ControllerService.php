<?php
require_once 'views/View.php';
/**
 *
 */
class ControllerService
{
  private $view;

  public function __construct()
  {
      if (isset($_GET['contact'])) {
        $this->contact();
    } else {
        throw new \Exception("Page Introuvable");
    }
  }

  public function contact(){
    // $this->_postManager = new PostManager();
    // $posts = $this->_postManager->getPosts();
    $this->view = new View('Contact');
    $this->view->generate(array());
  }
}

 ?>
