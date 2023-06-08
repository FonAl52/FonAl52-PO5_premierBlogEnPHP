<?php
require_once 'views/View.php';

class ControllerAdmin
{
    private $userManager;
    private $postManager;
    private $commentManager;
    private $view;

    public function __construct()
    {
        if (isset($_GET['management'])) {
            $this->management();
        } 
        else {
            throw new \Exception("Page Introuvable");
        }
    }

    public function management(){
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');
        
        $this->view = new View('Management');
        $this->view->generatePost(array('users' => $users, 'posts' => $posts,'comments' => $comments));
    }

    
}
