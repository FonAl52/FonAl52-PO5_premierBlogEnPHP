<?php
require_once 'models/UserManager.php';
require_once 'models/User.php';
require_once 'views/View.php';


class ControllerUser
{
    private $userManager;
    private $view;

    public function __construct()
    {
        if (isset($_GET['register'])) {
            $this->register();
        } elseif (isset($_GET['create'])) {
            $this->createUser();
        } else {
            throw new \Exception("Page Introuvable");
        }
    }
    
    //fonction pour afficher le formulaire d'inscription
    private function register()
    {
        $this->view = new View('Register');
        $this->view->generate(array());
    }

    //fonction pour traiter les données du formulaire d'inscription
    private function createUser()
    {
        $userManager = new UserManager();
        $newFields = array_map('htmlspecialchars', $_POST);
        // Valider les données soumises
        $errors = [];
        if (empty($newFields['firstName'])) {
            $errors['firstName'] = "Le prénom est obligatoire";
        }
        if (empty($newFields['lastName'])) {
            $errors['lastName'] = "Le nom est obligatoire";
        }
        if (empty($newFields['email'])) {
            $errors['email'] = "L'adresse email est obligatoire";
        } elseif (!filter_var($newFields['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'adresse email n'est pas valide";
        }
        $checkEmail = $userManager->getUserByEmail($newFields['email']);
        if ($checkEmail) {
            $errors['email'] = "L'email existe déjà";
        }
        if (empty($newFields['password'])) {
            $errors['password'] = "Le mot de passe est obligatoire";
        } elseif ($newFields['password'] !== $newFields['confirmPassword']) {
            $errors['password'] = "Les mots de passe ne correspondent pas";
        }

        // Si les données sont valides, créer un nouvel utilisateur et l'ajouter à la base de données
        if (empty($errors)) {
            $user = new User(array());
            $user->setFirstName($newFields['firstName']);
            $user->setLastName($newFields['lastName']);
            $user->setEmail($newFields['email']);
            $user->setPassword($newFields['password']);
            $user->setRole(0);
            if ($userManager->createUser($user)) {
                $_SESSION['message'] = "Votre compte a été créé avec succès !";
                header('location:user&connect');
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la création de votre compte. Veuillez réessayer ultérieurement.";
            }
        } else {
            $_SESSION['error'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        // Si les données ne sont pas valides ou si la création de l'utilisateur a échoué, afficher le formulaire d'inscription avec les erreurs
        $this->view = new View('Register');
        $this->view->generate(array('errors' => $errors));
    }



    //fonction pour afficher le formulaire de connexion
    private function connect()
    {
        $this->view = new View('Connect');
        $this->view->generate(array());
    }

    private function userLogin()
    {
        $userManager = new UserManager();
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        // Vérification de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Adresse email invalide";
        }

        // Vérification du mot de passe
        if (strlen($password) < 6) {
            $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères";
        }

        // S'il y a des erreurs, on les retourne
        if (!empty($errors)) {
            $this->view = new View('Connect');
            $this->view->generate(array('errors' => $errors));
            return;
        }

        // Vérification si l'utilisateur existe dans la base de données
        $user = $userManager->verifyPassword($email, $password);
        if (!$user) {
            $_SESSION['message'] = "Adresse email ou mot de passe invalide";
            $this->view = new View('Connect');
            $this->view->generate(array('errors' => $errors));
            return;
        }

        // Redirection vers la page d'accueil
        header('location:post&home');
    }

    private function disconnect()
    {
        // Supprimez toutes les variables de session
        session_unset();

        // Détruisez la session
        session_destroy();

        // Redirigez l'utilisateur vers la page de connexion
        header('location:user&connect');
    }

    private function resetPass()
    {
        $this->view = new View('ResetPassword');
        $this->view->generate(array());
    }

    private function verifyEmail()
    {
        $this->userManager = new UserManager;
        $errors = array(); // initialisation de la variable $errors
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $user = $this->userManager->getUserByEmail($email);
            if ($user) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header('location:user&resetPassword');
            } else {
                $_SESSION['email'] = "L'email renseigné n'existe pas dans notre base de données";
                header('location:user&resetPassword');
            }
        } else {
            $_SESSION['email'] = "L'email n'a pas été renseigné";
            header('location:user&resetPassword');
        }
        $_SESSION['errors'] = $errors; // Stocker les erreurs en session pour les afficher sur la page
        return $user;
    }

    private function changePassword()
    {
        $this->userManager = new UserManager;
        $newFields = array_map('htmlspecialchars', $_POST);
        // Valider les données soumises
        $errors = [];
        if (empty($newFields['new_password'])) {
            $errors['new_password'] = "Le nouveau mot de passe est obligatoire";
        } elseif (!empty($newFields['new_password']) && $newFields['new_password'] !== $newFields['confirm_password']) {
            $errors['new_password'] = "Les mots de passe ne correspondent pas";
        }
        // Si les données sont valides, mettre à jour le mot de passe dans la base de données
        if (empty($errors)) {
            $userId = $_SESSION['id'];
            $newPassword = $newFields['new_password'];
            $changePassword = $this->userManager->changePassword($userId, $newPassword);
            
            if ($changePassword) {
                $_SESSION['message'] = "Votre mot de passe a été mis à jour avec succès !";
                header('location:user&connect');
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la modification de votre mot de passe. Veuillez réessayer ultérieurement.";
            }
        } else {
            $_SESSION['error'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }
    
        // Si les données ne sont pas valides ou si la mise à jour a échoué, afficher le formulaire de modification avec les erreurs
        $this->view = new View('ResetPassword');
        $this->view->generate(array('errors' => $errors));
    }

    private function profile()
    {   
        $this->view = new View('Profile');
        $this->view->generate(array());
    }

    private function editLastName()
    {
        $this->userManager = new UserManager;
        $newFields = array_map('htmlspecialchars', $_POST);
        $userId = $_SESSION['id'];
    
        if (empty($newFields['lastName'])) {
            $errors['lastName'] = "Le nom est obligatoire";
        }
        // Vérifier si le nouveau nom de famille est valide
        if (!preg_match("/^[a-zA-Z'-]+$/", $newFields['lastName'])) {
            $errors['lastName'] = "Le nouveau nom de famille n'est pas valide";
        }
        if (empty($errors)) {
            // Récupérer l'utilisateur à partir de la base de données
            $user = $this->userManager->getUserById($userId);
            
            // Créer un tableau avec la mise à jour du nom de famille
            $updateOptions = array(
                'lastName' => $newFields['lastName']
            );
            
            // Mettre à jour l'utilisateur dans la base de données
            if (!$this->userManager->updateUser($user, $updateOptions)) 
            {
                $errors['lastName'] = "Erreur lors de la mise à jour du nom de famille de l'utilisateur";
            }
            // Mettre à jour le nom de famille dans la session
            $_SESSION['lastName'] = $newFields['lastName'];
        }
        
        header('location:user&profile');
    }
    

    private function editFirstName(){
        $this->userManager = new UserManager;
        $newFields = array_map('htmlspecialchars', $_POST);
        $userId = $_SESSION['id'];
    
        if (empty($newFields['firstName'])) {
            $errors['firstName'] = "Le prénom est obligatoire";
        }
        // Vérifier si le nouveau nom de famille est valide
        if (!preg_match("/^[a-zA-Z'-]+$/", $newFields['firstName'])) {
            $errors['firstName'] = "Le nouveau prénom n'est pas valide";
        }
        if (empty($errors)) {
            // Récupérer l'utilisateur à partir de la base de données
            $user = $this->userManager->getUserById($userId);
            
            // Créer un tableau avec la mise à jour du nom de famille
            $updateOptions = array(
                'firstName' => $newFields['firstName']
            );
            
            // Mettre à jour l'utilisateur dans la base de données
            if (!$this->userManager->updateUser($user, $updateOptions)) 
            {
                $errors['firstName'] = "Erreur lors de la mise à jour du prénom de l'utilisateur";
            }
            // Mettre à jour le nom de famille dans la session
            $_SESSION['firstName'] = $newFields['firstName'];
        }
        
        header('location:user&profile');   
    }

    private function editEmail() {
        $this->userManager = new UserManager;
        $newFields = array_map('htmlspecialchars', $_POST);
        $userId = $_SESSION['id'];
        $errors = [];
    
        if (empty($newFields['email'])) {
            $errors['errors'] = "L'email est obligatoire";
        }
        
        // Vérifier si le nouveau nom de famille est valide
        if (!filter_var($newFields['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['errors'] = "Le nouvel email n'est pas valide";
        }
    
        if ($this->userManager->getUserByEmail($newFields['email'])) {
            $errors['errors'] = "Un compte avec cet email existe déjà";
        }
    
        if (empty($errors)) {
            // Récupérer l'utilisateur à partir de la base de données
            $user = $this->userManager->getUserById($userId);
    
            // Créer un tableau avec la mise à jour du nom de famille
            $updateOptions = array(
                'email' => $newFields['email']
            );
    
            // Mettre à jour l'utilisateur dans la base de données
            if (!$this->userManager->updateUser($user, $updateOptions)) {
                $errors['errors'] = "Erreur lors de la mise à jour de l'email de l'utilisateur";
            } else {
                // Mettre à jour le nom de famille dans la session
                $_SESSION['email'] = $newFields['email'];
            }
        }
        header('location:user&profile'); 
    }
    


    public function editProfilePicture()
{
    $this->userManager = new UserManager;
    $userId = $_SESSION['id'];
    $picturePath = '';

    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        // Vérifier si le fichier est une image valide
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['profilePicture']['type'], $allowedTypes)) {
            // Générer un nouveau nom de fichier unique pour éviter les conflits de noms
            $fileName = uniqid('', true) . '.' . pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);

            // Déplacer le fichier téléchargé dans le dossier public/images/profile avec le nouveau nom de fichier
            $destination = 'public/images/profile/' . $fileName;
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $destination)) {
                $picturePath = $destination;
            } else {
                $errors['errors'] = "Erreur lors de l'upload de l'image";
            }
        } else {
            $errors['errors'] = "Le fichier téléchargé n'est pas une image valide";
        }
    } else {
        $errors['errors'] = "Le fichier n'a pas été téléchargé";
    }

    if (!empty($picturePath)) {
        // Mettre à jour l'utilisateur dans la base de données avec le nouveau chemin de l'image de profil
        $user = $this->userManager->getUserById($userId);
        $updateOptions = array('picture' => $picturePath);

        // Supprimer l'ancienne photo de profil de l'utilisateur s'il en avait déjà une
        if (!empty($user['picture'])) {
            unlink($user['picture']);
        }

        if ($this->userManager->updateUser($user, $updateOptions)) {
            // Mettre à jour la variable de session pour refléter le nouveau chemin de l'image de profil
            $_SESSION['picture'] = $picturePath;
            header('location:user&profile');
        } else {
            $errors['errors'] = "Erreur lors de la mise à jour du chemin de l'image de profil dans la base de données";
        }
    }

    // Si une erreur s'est produite, afficher un message d'erreur et rediriger vers la page de profil
    if (!empty($errors)) {
        $this->view->generate(array('errors' => $errors));
    }
}


}
