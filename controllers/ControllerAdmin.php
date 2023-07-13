<?php
require_once 'views/View.php';

class ControllerAdmin
{
    /**
     * User Manager instance.
     *
     * @var UserManager
     */
    private $userManager;

    /**
     * Post Manager instance.
     *
     * @var PostManager
     */
    private $postManager;

    /**
     * Comment Manager instance.
     *
     * @var CommentManager
     */
    private $commentManager;

    /**
     * Category Manager instance.
     *
     * @var CategoryManager
     */
    private $categoryManager;

    /**
     * View instance.
     *
     * @var View
     */
    private $view;


    /**
     * ControllerAdmin constructor.
     * Initializes the ControllerAdmin object.
     *
     * @throws \Exception If the page is not found.
     *
     * @return void
     */
    public function __construct()
    {
        if (isset($_GET['management']) === TRUE) {
            $this->management();
        }
        if (isset($_GET['managementUsers']) === TRUE) {
            $this->managementUsers();
        }
        if (isset($_GET['managementPosts']) === TRUE) {
            $this->managementPosts();
        }
        if (isset($_GET['managementComments']) === TRUE) {
            $this->managementComments();
        }
        if (isset($_GET['userLock']) === TRUE) {
            $this->userLock();
        }
        if (isset($_GET['userUnlock']) === TRUE) {
            $this->userUnlock();
        }
        if (isset($_GET['userDelete']) === TRUE) {
            $this->userDelete();
        }
        if (isset($_GET['userAdmin']) === TRUE) {
            $this->userAdmin();
        }
        if (isset($_GET['userNorole']) === TRUE) {
            $this->userNorole();
        }
        if (isset($_GET['postDelete']) === TRUE) {
            $this->postDelete();
        }
        if (isset($_GET['commentUnvalidate']) === TRUE) {
            $this->commentUnvalidate();
        }
        if (isset($_GET['commentValidate']) === TRUE) {
            $this->commentValidate();
        }
        if (isset($_GET['commentDelete']) === TRUE) {
            $this->commentDelete();
        }
        throw new \Exception("Page Introuvable");
    } //end __construct()


    /**
     * Display management view.
     *
     * @return void
     */
    public function management()
    {
        $this->view = new View('Management');
        $this->view->generatePost([]);
    } //end management()


    /**
     * Display managementUsers view.
     *
     * @return void
     */
    public function managementUsers()
    {
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');

        $this->view = new View('ManagementUsers');
        $this->view->generatePost(['users' => $users, 'posts' => $posts, 'comments' => $comments]);
    }


    /**
     * Display managementPosts view.
     *
     * @return void
     */
    public function managementPosts()
    {
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');
        $this->categoryManager = new CategoryManager;
        $categories = $this->categoryManager->getCategories();

        $this->view = new View('ManagementPosts');
        $this->view->generatePost(['users' => $users, 'posts' => $posts, 'comments' => $comments, 'categories' => $categories]);
    }


    /**
     * Display managementComments view.
     *
     * @return void
     */
    public function managementComments()
    {
        $this->userManager = new UserManager;
        $users = $this->userManager->getAllUsers();
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post');
        $this->commentManager = new CommentManager;
        $comments = $this->commentManager->getAll('comment');

        $this->view = new View('ManagementComments');
        $this->view->generatePost(['users' => $users, 'posts' => $posts, 'comments' => $comments]);
    }


    /**
     * Change userRole to lock.
     *
     * @return void
     */
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


    /**
     * Change userRole to unlock.
     *
     * @return void
     */
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


    /**
     * Delete a user.
     *
     * @return void
     */
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


    /**
     * Change userRole to admin.
     *
     * @return void
     */
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

    
    /**
     * Remove admin role.
     *
     * @return void
     */
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


    /**
     * Delete a post.
     *
     * @return void
     */
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


    /**
     * Validate a comment.
     *
     * @return void
     */
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


    /**
     * Unvalidate a comment.
     *
     * @return void
     */
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


    /**
     * Delete a comment.
     *
     * @return void
     */
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
