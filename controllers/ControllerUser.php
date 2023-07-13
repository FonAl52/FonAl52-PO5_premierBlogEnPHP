<?php
require_once 'models/UserManager.php';
require_once 'models/User.php';
require_once 'views/View.php';


class ControllerUser
{
    private $userManager;
    private $view;

    /**
     * ControllerUser constructor.
     * Initializes the ControllerComment object.
     *
     * @throws \Exception If the page is not found.
     *
     * @return void
     */
    public function __construct()
    {
        if (isset($_GET['register'])) {
            $this->register();
        } elseif (isset($_GET['create'])) {
            $this->createUser();
        } elseif (isset($_GET['connect'])) {
            $this->connect();
        } elseif (isset($_GET['login'])) {
            $this->userLogin();
        } elseif (isset($_GET['resetPassword'])) {
            $this->resetPass();
        } elseif (isset($_GET['verifyEmail'])) {
            $this->verifyEmail();
        } elseif (isset($_GET['changePassword'])) {
            $this->changePassword();
        } elseif (isset($_GET['disconnect'])) {
            $this->disconnect();
        } elseif (isset($_GET['profile'])) {
            $this->profile();
        } elseif (isset($_GET['editLastName'])) {
            $this->profile();
        } elseif (isset($_GET['changeLastName'])) {
            $this->editLastName();
        } elseif (isset($_GET['editFirstName'])) {
            $this->profile();
        } elseif (isset($_GET['changeFirstName'])) {
            $this->editFirstName();
        } elseif (isset($_GET['editEmail'])) {
            $this->profile();
        } elseif (isset($_GET['changeEmail'])) {
            $this->editEmail();
        } elseif (isset($_GET['editProfilePicture'])) {
            $this->profile();
            $this->editProfilePicture();
        } elseif (isset($_GET['changeProfilePicture'])) {
            $this->editProfilePicture();
        } else {
            throw new \Exception("Page Introuvable");
        }

    }//end __construct()

    
    private function register()
    {
        $this->view = new View('Register');
        $this->view->generate(array());
    }

    private function createUser()
    {
        $userManager = new UserManager();
        $newFields = array_map('htmlspecialchars', $_POST);
        // Validate submitted data
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

        // If data is valid, create a new user and add it to the database
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
                $_SESSION['message'] = "Une erreur est survenue lors de la création de votre compte. Veuillez réessayer ultérieurement.";
            }
        } else {
            $_SESSION['message'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        // If the data is invalid or the user creation has failed, display the registration form with the errors
        $this->view = new View('Register');
        $this->view->generate(array('errors' => $errors));
    }

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

        // Email verification
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Adresse email invalide";
        }

        // Password verification
        if (strlen($password) < 6) {
            $errors['password'] = "Le mot de passe doit contenir au moins 6 caractères";
        }

        // Display errors
        if (!empty($errors)) {
            $this->view = new View('Connect');
            $this->view->generate(array('errors' => $errors));
            return;
        }
        // Checking if the user exists in the database
        $user = $userManager->verifyPassword($email, $password);
        if (!$user) {
            $_SESSION['message'] = "Adresse email ou mot de passe invalide";
            $this->view = new View('Connect');
            $this->view->generate(array('errors' => $errors));
            return;
        }
        // Check user role
        if ($user['role'] == 3) {
            $_SESSION['message'] = "Votre compte est verrouillé. Veuillez contacter l'administrateur.";

            $this->view = new View('Connect');
            $this->view->generate(array('errors' => $errors));
        }
        // Redirect to homepage
        header('location:post&home');
    }

    private function resetPass()
    {
        $this->view = new View('ResetPassword');
        $this->view->generate(array());
    }

    private function verifyEmail()
    {
        $this->userManager = new UserManager;
        $errors = array();
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
        $_SESSION['errors'] = $errors;
    }

    private function changePassword()
    {
        $this->userManager = new UserManager;
        $newFields = array_map('htmlspecialchars', $_POST);
        // Validate submitted data
        $errors = [];
        if (empty($newFields['new_password'])) {
            $errors['new_password'] = "Le nouveau mot de passe est obligatoire";
        } elseif (!empty($newFields['new_password']) && $newFields['new_password'] !== $newFields['confirm_password']) {
            $errors['new_password'] = "Les mots de passe ne correspondent pas";
        }
        // If data is valid, update password in database
        if (empty($errors)) {
            $userId = $_SESSION['id'];
            $newPassword = $newFields['new_password'];
            $changePassword = $this->userManager->changePassword($userId, $newPassword);

            if ($changePassword) {
                $_SESSION['message'] = "Votre mot de passe a été mis à jour avec succès !";
                header('location:user&connect');
            } else {
                $_SESSION['message'] = "Une erreur est survenue lors de la modification de votre mot de passe. Veuillez réessayer ultérieurement.";
            }
        } else {
            $_SESSION['message'] = "Des erreurs ont été détectées dans le formulaire. Veuillez les corriger et réessayer.";
        }

        // If the data is not valid or if the update fails, display the modification form with the errors.
        $this->view = new View('ResetPassword');
        $this->view->generate(array('errors' => $errors));
    }

    private function disconnect()
    {
        session_unset();
        session_destroy();

        header('location:user&connect');
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
        // Check if the new last name is valid
        if (!preg_match("/^[a-zA-Z'-]+$/", $newFields['lastName'])) {
            $errors['lastName'] = "Le nouveau nom de famille n'est pas valide";
        }
        if (empty($errors)) {
            // Retrieve the user from the database
            $user = $this->userManager->getUserById($userId);

            // Create an array with the updated last name
            $updateOptions = array(
                'lastName' => $newFields['lastName']
            );

            // Update the user in the database
            if (!$this->userManager->updateUser($user, $updateOptions)) {
                $errors['lastName'] = "Erreur lors de la mise à jour du nom de famille de l'utilisateur";
            }
            // Update the last name in the session
            $_SESSION['lastName'] = $newFields['lastName'];
            $_SESSION['message'] = "Profile mis à jour avec succès";
        }

        header('location:user&profile');
    }

    private function editFirstName()
    {
        $this->userManager = new UserManager;
        $newFields = array_map('htmlspecialchars', $_POST);
        $userId = $_SESSION['id'];

        if (empty($newFields['firstName'])) {
            $errors['firstName'] = "Le prénom est obligatoire";
        }
        // Check if the new firstname is valid
        if (!preg_match("/^[a-zA-Z'-]+$/", $newFields['firstName'])) {
            $errors['firstName'] = "Le nouveau prénom n'est pas valide";
        }
        if (empty($errors)) {
            // Retrieve the user from the database
            $user = $this->userManager->getUserById($userId);

            // Create an array with the updated firstname
            $updateOptions = array(
                'firstName' => $newFields['firstName']
            );

            // Update the user in the database
            if (!$this->userManager->updateUser($user, $updateOptions)) {
                $errors['firstName'] = "Erreur lors de la mise à jour du prénom de l'utilisateur";
            }
            // Update the firstname in the session
            $_SESSION['firstName'] = $newFields['firstName'];
            $_SESSION['message'] = "Profile mis à jour avec succès";
        }

        header('location:user&profile');
    }

    private function editEmail()
    {
        $this->userManager = new UserManager;
        $newFields = array_map('htmlspecialchars', $_POST);
        $userId = $_SESSION['id'];
        $errors = [];

        if (empty($newFields['email'])) {
            $errors['errors'] = "L'email est obligatoire";
        }

        // Check if email is valid
        if (!filter_var($newFields['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['errors'] = "Le nouvel email n'est pas valide";
        }

        if ($this->userManager->getUserByEmail($newFields['email'])) {
            $errors['errors'] = "Un compte avec cet email existe déjà";
        }

        if (empty($errors)) {
            // Retrieve the user from the database
            $user = $this->userManager->getUserById($userId);

            // Create an array with the updated email
            $updateOptions = array(
                'email' => $newFields['email']
            );

            // Update the user in the database
            if (!$this->userManager->updateUser($user, $updateOptions)) {
                $errors['errors'] = "Erreur lors de la mise à jour de l'email de l'utilisateur";
            } else {
                // Update email in the session
                $_SESSION['email'] = $newFields['email'];
                $_SESSION['message'] = "Profile mis à jour avec succès";
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
            // Check if the file is a valid image
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['profilePicture']['type'], $allowedTypes)) {
                // Generate a new unique file name to avoid naming conflicts
                $fileName = uniqid('', true) . '.' . pathinfo($_FILES['profilePicture']['name'], PATHINFO_EXTENSION);

                // Move the uploaded file to the public/images/profile folder with the new file name
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
            // Update user in database with new picture profile path
            $user = $this->userManager->getUserById($userId);
            $updateOptions = array('picture' => $picturePath);
            // Delete old picture profile if there is
            if (!empty($user['picture'])) {
                unlink($user['picture']);
            }
            if ($this->userManager->updateUser($user, $updateOptions)) {
                // Update session to show new picture
                $_SESSION['picture'] = $picturePath;
                $_SESSION['message'] = "Profile mis à jour avec succès";
                header('location:user&profile');
            } else {
                $errors['errors'] = "Erreur lors de la mise à jour du chemin de l'image de profil dans la base de données";
            }
        }
        //Display errors
        if (!empty($errors)) {
            $this->view->generate(array('errors' => $errors));
        }
    }
}
