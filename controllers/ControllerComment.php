<?php
require_once 'views/View.php';
require_once 'models/Comment.php';
require_once 'models/CommentManager.php';

class ControllerComment

{
    private $commentManager;
    private $view;

    public function __construct()
    {
        if (isset($url) && count($url) < 1) {
        throw new \Exception("Page Introuvable");
        }
        elseif (isset($_GET['create'])) {
        $this->createComment();
        
        }
        else {
            throw new \Exception("Page Introuvable");
        }
    }

    
    public function createComment()
  {
    $commentManager = new CommentManager();
    $newFields = array_map('htmlspecialchars', $_POST);
    $postId = $newFields['postId'];
    // Valider les données soumises
    $errors = [];
    if (empty($newFields['postId'])) {
      $errors['postId'] = "Une erreur est survenue merci de nous contacter";
    }
    if (empty($newFields['userId'])) {
      $errors['userId'] = "Une erreur est survenue merci de nous contacter";
    }
    if (empty($newFields['comment'])) {
      $errors['comment'] = "Le contenu du commentaire ne peut pas être vide";
    }
    // Si les données sont valides, créer un nouvel article et l'ajouter à la base de données
    if (empty($errors)) {
      $comment = new Comment(array());
      $comment->setPostId($newFields['postId']);
      $comment->setUserId($newFields['userId']);
      $comment->setComment($newFields['comment']);
    
      if ($commentManager->createComment($comment)) {
        $_SESSION['message'] = "Votre commentaire a été envoyer avec succès ! Il sera visible un foie vérifié";
      } else {
        $errors['errors'] = "Une erreur est survenue lors de la création de votre commentaire. Veuillez réessayer ultérieurement.";
      }
    } else {
      $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
    }
    
    // Si les données ne sont pas valides ou si la création de l'article a échoué, afficher le formulaire avec les erreurs
    header('Location: post&id='.$newFields['postId']);
    
  }
  
}

 ?>
