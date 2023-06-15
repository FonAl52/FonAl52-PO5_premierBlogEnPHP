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
        if (isset($_GET['userLock'])) {
            $this->userLock();
        }
        if (isset($_GET['userUnlock'])) {
            $this->userUnlock();
        }
        if (isset($_GET['userDelete'])) {
            $this->userDelete();
        }
        if (isset($_GET['userAdmin'])) {
            $this->userAdmin();
        }
        if (isset($_GET['userNorole'])) {
            $this->userNorole();
        }
        if (isset($_GET['postDelete'])) {
            $this->postDelete();
        } else {
            throw new \Exception("Page Introuvable");
        }
    }

    public function management()
    {
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');

        $this->view = new View('Management');
        $this->view->generatePost(array('users' => $users, 'posts' => $posts, 'comments' => $comments));
    }

    public function userLock()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 3
        );

        $this->userManager->updateUserRole($userId, $updateRole);
        header('Location: admin&management');
    }

    public function userUnlock()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 0
        );

        $this->userManager->updateUserRole($userId, $updateRole);
        header('Location: admin&management');
    }

    public function userDelete()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $this->userManager->deleteUser($userId);
        header('Location: admin&management');
    }

    public function userAdmin()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 1
        );

        $this->userManager->updateUserRole($userId, $updateRole);
        header('Location: admin&management');
    }

    public function userNorole()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 0
        );

        $this->userManager->updateUserRole($userId, $updateRole);
        header('Location: admin&management');
    }

    public function postDelete()
    {
        $this->postManager = new PostManager;

        $postId = $_GET['id'];
        $post = $this->postManager->getPost($postId);

        $fileName = $post[0]->getPicture();

        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $this->postManager->deletePost($postId);
        header('Location: admin&management');
    }
}
