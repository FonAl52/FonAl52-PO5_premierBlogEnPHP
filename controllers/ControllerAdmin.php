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
        if (isset($_GET['managementUsers'])) {
            $this->managementUsers();
        }
        if (isset($_GET['managementPosts'])) {
            $this->managementPosts();
        }
        if (isset($_GET['managementComments'])) {
            $this->managementComments();
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
        }
        if (isset($_GET['commentUnvalidate'])) {
            $this->commentUnvalidate();
        }
        if (isset($_GET['commentValidate'])) {
            $this->commentValidate();
        }
        if (isset($_GET['commentDelete'])) {
            $this->commentDelete();
        } else {
            throw new \Exception("Page Introuvable");
        }
    }

    public function management()
    {
        $this->view = new View('Management');
        $this->view->generatePost(array());
    }

    public function managementUsers()
    {
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');

        $this->view = new View('ManagementUsers');
        $this->view->generatePost(array('users' => $users, 'posts' => $posts, 'comments' => $comments));
    }

    public function managementPosts()
    {
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');

        $this->view = new View('ManagementPosts');
        $this->view->generatePost(array('users' => $users, 'posts' => $posts, 'comments' => $comments));
    }

    public function managementComments()
    {
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');

        $this->view = new View('ManagementComments');
        $this->view->generatePost(array('users' => $users, 'posts' => $posts, 'comments' => $comments));
    }

    public function userLock()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 3
        );

        try {
            $this->userManager->updateUserRole($userId, $updateRole);
            $_SESSION['success_message'] = "L'utilisateur a été bloqué avec succès.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour de l'utilisateur.";
        }

        header('Location: admin&managementUsers');
    }


    public function userUnlock()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 0
        );

        try {
            $this->userManager->updateUserRole($userId, $updateRole);
            $_SESSION['success_message'] = "L'utilisateur a été débloqué avec succès.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour de l'utilisateur.";
        }

        header('Location: admin&managementUsers');
    }

    public function userDelete()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];

        try {
            $this->userManager->deleteUser($userId);
            $_SESSION['success_message'] = "L'utilisateur a été supprimer avec succès.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la suppression de l'utilisateur.";
        }

        header('Location: admin&managementUsers');
    }

    public function userAdmin()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 1
        );

        try {
            $this->userManager->updateUserRole($userId, $updateRole);
            $_SESSION['success_message'] = "L'utilisateur est maintenant un administrateur.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour de l'utilisateur.";
        }

        header('Location: admin&managementUsers');
    }

    public function userNorole()
    {
        $this->userManager = new UserManager;

        $userId = $_GET['id'];
        $updateRole = array(
            'role' => 0
        );

        try {
            $this->userManager->updateUserRole($userId, $updateRole);
            $_SESSION['success_message'] = "L'utilisateur n'est plus un administrateur.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour de l'utilisateur.";
        }

        header('Location: admin&managementUsers');
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

        try {
            $this->postManager->deletePost($postId);
            $_SESSION['success_message'] = "L'article à été supprimé.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la suppression de l'article.";
        }

        header('Location: admin&managementPosts');
    }

    public function commentValidate()
    {
        $this->commentManager = new CommentManager;

        $commentId = $_GET['id'];
        $validation = array(
            'validated' => 1
        );

        try {
            $this->commentManager->commentValidation($commentId, $validation);
            $_SESSION['success_message'] = "Le commentaire à été validé.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour du commentaire.";
        }


        header('Location: admin&managementComments');
    }

    public function commentUnvalidate()
    {
        $this->commentManager = new CommentManager;

        $commentId = $_GET['id'];
        $validation = array(
            'validated' => 0
        );

        try {
            $this->commentManager->commentValidation($commentId, $validation);
            $_SESSION['success_message'] = "Le commentaire n'est plus validé.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour du commentaire.";
        }

        header('Location: admin&managementComments');
    }

    public function commentDelete()
    {
        $this->commentManager = new CommentManager;

        $commentId = $_GET['id'];

        try {
            $this->commentManager->deleteComment($commentId);
            $_SESSION['success_message'] = "Le commentaire à été supprimé.";
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Une erreur s'est produite lors de la suppression du commentaire.";
        }

        header('Location: admin&managementComments');
    }
}
