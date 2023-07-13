<?php
require_once 'views/View.php';
require_once 'models/Comment.php';
require_once 'models/CommentManager.php';


class ControllerComment
{


    /**
     * ControllerComment constructor.
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
        } else if (isset($_GET['create']) === TRUE) {
            $this->createComment();
        } else {
            throw new \Exception("Page Introuvable");
        }

    }//end __construct()


    /**
     * Create a new comment.
     *
     * @return void
     */
    public function createComment()
    {
        $commentManager = new CommentManager();
        $newFields = array_map('htmlspecialchars', $_POST);

        // Validate the submitted data.
        $errors = [];

        if (empty($newFields['postId']) === TRUE) {
            $errors['postId'] = "Une erreur est survenue merci de nous contacter";
        }
        
        if (empty($newFields['userId']) === TRUE) {
            $errors['userId'] = "Une erreur est survenue merci de nous contacter";
        }
        if (empty($newFields['comment']) === TRUE) {
            $errors['comment'] = "Le contenu du commentaire ne peut pas être vide";
        }

        // If the data are valid, create a new article and add it to the database.
        if (empty($errors) === TRUE) {
            $comment = new Comment([]);
            $comment->setPostId($newFields['postId']);
            $comment->setUserId($newFields['userId']);
            $comment->setComment($newFields['comment']);

            if ($commentManager->createComment($comment) === TRUE) {
                $_SESSION['message'] = "Votre commentaire a été envoyer avec succès ! Il sera visible un foie vérifié";
            } else {
                $errors['errors'] = "Une erreur est survenue lors de la création de votre commentaire. Veuillez réessayer ultérieurement.";
            }
        } else {
            $errors['errors'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }
        // If the data is not valid or if the article creation failed, display the form with the errors.
        header('Location: post&id='.$newFields['postId']);

    }//end createComment()

}
