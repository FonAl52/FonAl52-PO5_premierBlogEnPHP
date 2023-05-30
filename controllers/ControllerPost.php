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

  public function __construct()
  {
    if (isset($url) && count($url) < 1) {
      throw new \Exception("Page Introuvable");
    }
    elseif (isset($_GET['home'])) {
      $this->home();
    }
    elseif (isset($_GET['newPost']) && $_SESSION['role']== 1) {
      $this->create();
    }
    elseif (isset($_GET['new']) && $_SESSION['role']== 1) {
      $this->addPost();
    }
    elseif (isset($_GET['viewAll']) ) {
      $this->viewAll();
    }
    elseif (isset($_GET['id'])) {
      $this->viewOne();
    }
    else {
      $this->home();
    }
  }

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

    // Valider les données soumises
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
      // Vérifier si le fichier est une image valide
      $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
      if (in_array($_FILES['picture']['type'], $allowedTypes)) {
        // Vérifier la taille du fichier
        $maxFileSize = 2097152; // 2 Mo
        if ($_FILES['picture']['size'] > $maxFileSize) {
          $errors['picture'] = 'La taille du fichier dépasse la limite autorisée.';
        } else {
          // Générer un nouveau nom de fichier unique pour éviter les conflits de noms
          $fileName = uniqid('', true) . '.' . pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

          // Déplacer le fichier téléchargé dans le dossier public/images/posts avec le nouveau nom de fichier
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
    // Si les données sont valides, créer un nouvel article et l'ajouter à la base de données
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

    // Si les données ne sont pas valides ou si la création de l'article a échoué, afficher le formulaire avec les erreurs
    $this->view = new View('CreatePost');
    $this->view->generate(array('errors' => $errors, 'categories' => $categories));
  }

  private function categoryId(){
    $this->categoryManager = new CategoryManager();
    $categories = $this->categoryManager->getCategories();

    return $categories;
  }

  public function viewAll(){
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



}
