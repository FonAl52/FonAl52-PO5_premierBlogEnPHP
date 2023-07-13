<?php
require_once 'views/View.php';
require_once 'models/CategoryManager.php';
require_once 'models/UserManager.php';
require_once 'models/Post.php';
require_once 'models/PostManager.php';
require_once 'models/Comment.php';
require_once 'models/CommentManager.php';
class ControllerPost

{
    private $view;
    private $categoryManager;
    private $postManager;
    private $userManager;
    private $commentManager;

    /**
     * ControllerPost constructor.
     * Initializes the ControllerComment object.
     *
     * @throws \Exception If the page is not found.
     *
     * @return void
     */
    public function __construct()
    {
        if (isset($url) && count($url) < 1) {
            throw new \Exception("Page Introuvable");
        } elseif (isset($_GET['home'])) {
            $this->home();
        } elseif (isset($_GET['newPost']) && $_SESSION['role'] == 1) {
            $this->create();
        } elseif (isset($_GET['new']) && $_SESSION['role'] == 1) {
            $this->addPost();
        } elseif (isset($_GET['viewAll'])) {
            $this->viewAll();
        } elseif (isset($_GET['editPost'])) {
            $this->update();
        } elseif (isset($_GET['updateTitle'])) {
            $this->updatePostTitle();
        } elseif (isset($_GET['updateCategory'])) {
            $this->updatePostCategory();
        } elseif (isset($_GET['updateChapo'])) {
            $this->updatePostChapo();
        } elseif (isset($_GET['updatePicture'])) {
            $this->updatePostPicture();
        } elseif (isset($_GET['updateContent'])) {
            $this->updatePostContent();
        } elseif (isset($_GET['id']) && (isset($_GET['id']))) {
            $this->viewOne();
        } else {
            $this->home();
        }

    }//end __construct()

    
    public function home()
    {
        $this->postManager = new PostManager();
        $posts = $this->getAllPosts();
        $categories = $this->categoryId();
        $users = $this->getAllUsers();

        $this->view = new View('Home');
        $this->view->generate(array('posts' => $posts, 'categories' => $categories, 'users' => $users));
    }

    private function create()
    {
        $categories = $this->categoryId();

        $this->view = new View('CreatePost');
        $this->view->generate(array('categories' => $categories));
    }

    public function addPost()
    {
        $categories = $this->categoryId();

        $postManager = new PostManager();
        $newFields = array_map('htmlspecialchars', $_POST);
        $picturePath = '';
        $userId = $_SESSION["id"];

        // Validate submitted data
        $errors = [];
        if (empty($newFields['title'])) {
            $errors['title'] = "Le titre est obligatoire";
        }
        if (empty($newFields['chapo'])) {
            $errors['chapo'] = "Le chapo est obligatoire";
        }
        if (empty($_FILES['picture']['name'])) {
            $errors['picture'] = "Choisissez une photo pour votre article";
        } else {
            // Check if the file is a valid image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['picture']['type'], $allowedTypes)) {
                // Check the file size
                $maxFileSize = 2097152; // 2 Mo
                if ($_FILES['picture']['size'] > $maxFileSize) {
                    $errors['picture'] = 'La taille du fichier dépasse la limite autorisée.';
                } else {
                    // Generate a new unique file name to avoid naming conflicts
                    $fileName = uniqid('', true) . '.' . pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

                    // Move the uploaded file to the public/images/posts folder with the new file name
                    $destination = 'public/images/posts/' . $fileName;
                    if (move_uploaded_file($_FILES['picture']['tmp_name'], $destination)) {
                        $picturePath = $destination;
                    } else {
                        $errors['picture'] = "Erreur lors de l'upload de l'image";
                    }
                }
            } else {
                $errors['picture'] = "Le fichier téléchargé n'est pas une image valide";
            }
        }
        if (empty($newFields['content'])) {
            $errors['content'] = "Le contenu de l'article ne peut pas être vide";
        }
        if (empty($newFields['categoryId'])) {
            $errors['categoryId'] = "Merci de choisir une catégorie d'article";
        }
        // If the data is valid, create a new article and add it to the database
        if (empty($errors)) {
            $post = new Post(array());
            $post->setTitle($newFields['title']);
            $post->setChapo($newFields['chapo']);
            $post->setPicture($picturePath);
            $post->setContent($newFields['content']);
            $post->setCategoryId($newFields['categoryId']);
            $post->setUserId($userId);

            if ($postManager->createPost($post)) {
                $_SESSION['message'] = "Votre article a été créé avec succès !";
                header('location:post&home');
            } else {
                $errors['errors'] = "Une erreur est survenue lors de la création de votre article. Veuillez réessayer ultérieurement.";
            }
        } else {
            $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }
        // If the data is not valid or if the article creation failed, display the form with the errors
        $this->view = new View('CreatePost');
        $this->view->generate(array('errors' => $errors, 'categories' => $categories));
    }

    private function categoryId()
    {
        $this->categoryManager = new CategoryManager();
        $categories = $this->categoryManager->getCategories();

        return $categories;
    }

    public function viewAll()
    {
        $this->postManager = new PostManager();
        $posts = $this->getAllPosts();
        $categories = $this->categoryId();
        $users = $this->getAllUsers();

        $this->view = new View('AllPosts');
        $this->view->generate(array('posts' => $posts, 'categories' => $categories, 'users' => $users));
    }

    private function getAllPosts()
    {
        $this->postManager = new PostManager;
        $posts = $this->postManager->getAll('post', 'posts');

        return $posts;
    }

    private function getAllUsers()
    {
        $userManager = new UserManager();
        $users = $userManager->getAllUsers();

        return $users;
    }

    private function viewOne()
    {
        if (isset($_GET['id'], $_GET['id'])) {
            $this->postManager = new PostManager;
            $this->userManager = new UserManager;
            $this->commentManager = new CommentManager;
            $postId = $_GET['id'];

            $post = $this->postManager->getPost($_GET['id']);
            $categories = $this->categoryId();
            $users = $this->getAllUsers();
            $comments =  $this->commentManager->getCommentsByPostId($postId);

            $this->view = new View('SinglePost');
            $this->view->generate(array('post' => $post, 'categories' => $categories, 'users' => $users, 'comments' => $comments));
        }
    }

    private function update()
    {
        if (isset($_GET['id'], $_GET['id'])) {
            $this->postManager = new PostManager;
            $this->userManager = new UserManager;
            $this->commentManager = new CommentManager;
            $postId = $_GET['id'];

            $post = $this->postManager->getPost($_GET['id']);
            $categories = $this->categoryId();
            $users = $this->getAllUsers();
            $comments =  $this->commentManager->getCommentsByPostId($postId);

            $this->view = new View('updatePost');
            $this->view->generate(array('post' => $post, 'categories' => $categories, 'users' => $users, 'comments' => $comments));
        }
    }

    private function updatePostTitle()
    {
        $this->postManager = new PostManager;
        $this->userManager = new UserManager;
        $this->commentManager = new CommentManager;
        $postId = $_GET['id'];

        $post = $this->postManager->getPost($_GET['id']);
        $categories = $this->categoryId();
        $users = $this->getAllUsers();
        $comments =  $this->commentManager->getCommentsByPostId($postId);

        $newFields = array_map('htmlspecialchars', $_POST);
        $dateTime = date('Y-m-d H:i:s');
        // Validate submitted data
        $errors = [];
        if (empty($newFields)) {
            $errors['title'] = "Merci de complété au moins un des champs";
        }
        // If the data is valid, update the article in the database
        if (empty($errors)) {
            $updatepost = array(
                'title' => $newFields['title'],
                'updatedAt' => $dateTime,
            );
            if ($this->postManager->updatePost($postId, $updatepost)) {
                $_SESSION['message'] = "Votre article a été modifier avec succès !";
            } else {
                $errors['errors'] = "Une erreur est survenue lors de la modification de votre article. Veuillez réessayer ultérieurement.";
            }
        } else {
            $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        $this->view = new View('SinglePost');
        $this->view->generate(array('post' => $post, 'categories' => $categories, 'users' => $users, 'comments' => $comments));
    }

    private function updatePostCategory()
    {
        $this->postManager = new PostManager;
        $this->userManager = new UserManager;
        $this->commentManager = new CommentManager;
        $postId = $_GET['id'];

        $post = $this->postManager->getPost($_GET['id']);
        $categories = $this->categoryId();
        $users = $this->getAllUsers();
        $comments =  $this->commentManager->getCommentsByPostId($postId);

        $newFields = array_map('htmlspecialchars', $_POST);
        $dateTime = date('Y-m-d H:i:s');
        // Validate submitted data
        $errors = [];
        if (empty($newFields)) {
            $errors['categoryId'] = "Merci de complété au moins un des champs";
        }
        // If the data is valid, update the article in the database
        if (empty($errors)) {
            $updatepost = array(
                'categoryId' => $newFields['categoryId'],
                'updatedAt' => $dateTime,
            );
            if ($this->postManager->updatePost($postId, $updatepost)) {
                $_SESSION['message'] = "Votre article a été modifier avec succès !";
            } else {
                $errors['errors'] = "Une erreur est survenue lors de la modification de votre article. Veuillez réessayer ultérieurement.";
            }
        } else {
            $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        $this->view = new View('SinglePost');
        $this->view->generate(array('post' => $post, 'categories' => $categories, 'users' => $users, 'comments' => $comments));
    }

    private function updatePostChapo()
    {
        $this->postManager = new PostManager;
        $this->userManager = new UserManager;
        $this->commentManager = new CommentManager;
        $postId = $_GET['id'];

        $post = $this->postManager->getPost($_GET['id']);
        $categories = $this->categoryId();
        $users = $this->getAllUsers();
        $comments =  $this->commentManager->getCommentsByPostId($postId);

        $newFields = array_map('htmlspecialchars', $_POST);
        $dateTime = date('Y-m-d H:i:s');
        // Validate submitted data
        $errors = [];
        if (empty($newFields)) {
            $errors['chapo'] = "Merci de complété au moins un des champs";
        }
        // If the data is valid, update the article in the database
        if (empty($errors)) {
            $updatepost = array(
                'chapo' => $newFields['chapo'],
                'updatedAt' => $dateTime,
            );
            if ($this->postManager->updatePost($postId, $updatepost)) {
                $_SESSION['message'] = "Votre article a été modifier avec succès !";
            } else {
                $errors['errors'] = "Une erreur est survenue lors de la modification de votre article. Veuillez réessayer ultérieurement.";
            }
        } else {
            $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        $this->view = new View('SinglePost');
        $this->view->generate(array('post' => $post, 'categories' => $categories, 'users' => $users, 'comments' => $comments));
    }

    private function updatePostPicture()
    {
        $this->postManager = new PostManager;
        $this->userManager = new UserManager;
        $this->commentManager = new CommentManager;
        $postId = $_GET['id'];

        $post = $this->postManager->getPost($_GET['id']);
        $categories = $this->categoryId();
        $users = $this->getAllUsers();
        $comments =  $this->commentManager->getCommentsByPostId($postId);

        $newFields = array_map('htmlspecialchars', $_POST);
        $dateTime = date('Y-m-d H:i:s');
        $picturePath = '';
        $oldPicture = $post[0]->getPicture();
        // Validate submitted data
        $errors = [];
        if (empty($newFields)) {
            $errors['chapo'] = "Merci de complété au moins un des champs";
        } else {
            // Check if the file is a valid image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['picture']['type'], $allowedTypes)) {
                // Check the file size
                $maxFileSize = 2097152; // 2 Mo
                if ($_FILES['picture']['size'] > $maxFileSize) {
                    $errors['picture'] = 'La taille du fichier dépasse la limite autorisée.';
                } else {
                    // Generate a new unique file name to avoid naming conflicts
                    $fileName = uniqid('', true) . '.' . pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                    // Move the uploaded file to the public/images/posts folder with the new file name
                    $destination = 'public/images/posts/' . $fileName;
                    if (move_uploaded_file($_FILES['picture']['tmp_name'], $destination)) {
                        $picturePath = $destination;
                    } else {
                        $errors['picture'] = "Erreur lors de l'upload de l'image";
                    }
                }
            } else {
                $errors['picture'] = "Le fichier téléchargé n'est pas une image valide";
            }
        }
        // If the data is valid, update the article in the database
        if (empty($errors)) {
            $updatepost = array(
                'picture' => $picturePath,
                'updatedAt' => $dateTime,
            );
            if (!empty($oldPicture)) {
                unlink($oldPicture);
            }
            if ($this->postManager->updatePost($postId, $updatepost)) {
                $_SESSION['message'] = "Votre article a été modifier avec succès !";
            } else {
                $errors['errors'] = "Une erreur est survenue lors de la modification de votre article. Veuillez réessayer ultérieurement.";
            }
        } else {
            $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        $this->view = new View('SinglePost');
        $this->view->generate(array('post' => $post, 'categories' => $categories, 'users' => $users, 'comments' => $comments));
    }

    private function updatePostContent()
    {
        $this->postManager = new PostManager;
        $this->userManager = new UserManager;
        $this->commentManager = new CommentManager;
        $postId = $_GET['id'];

        $post = $this->postManager->getPost($_GET['id']);
        $categories = $this->categoryId();
        $users = $this->getAllUsers();
        $comments =  $this->commentManager->getCommentsByPostId($postId);

        $newFields = array_map('htmlspecialchars', $_POST);
        $dateTime = date('Y-m-d H:i:s');
        // Validate submitted data
        $errors = [];
        if (empty($newFields)) {
            $errors['content'] = "Merci de complété au moins un des champs";
        }
        // If the data is valid, update the article in the database
        if (empty($errors)) {
            $updatepost = array(
                'content' => $newFields['content'],
                'updatedAt' => $dateTime,
            );
            if ($this->postManager->updatePost($postId, $updatepost)) {
                $_SESSION['message'] = "Votre article a été modifier avec succès !";
            } else {
                $errors['errors'] = "Une erreur est survenue lors de la modification de votre article. Veuillez réessayer ultérieurement.";
            }
        } else {
            $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        $this->view = new View('SinglePost');
        $this->view->generate(array('post' => $post, 'categories' => $categories, 'users' => $users, 'comments' => $comments));
    }
}
