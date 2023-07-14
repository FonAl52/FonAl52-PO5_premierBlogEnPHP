<?php

/**
 *
 */
class UserManager extends Model
{


    /**
     * Create a new user.
     *
     * @param   User $user The user object containing the user data.
     * @return bool True if the user creation was successful, false otherwise.
     */
    public function createUser($user)
    {
        if (!($user instanceof User)) {
            return false;
        }

        return $this->createOne('user', $user);

    }//end createUser()


    /**
     * Create a new record in the specified table.
     *
     * @param   string $table The name of the table.
     * @param   object $obj The object containing the data for the record.
     * @return bool True if the user creation was successful, false otherwise.
     */
    private function createOne($table, $obj)
    {
        $this->getBdd();
        $req = self::$bdd->prepare("INSERT INTO ".$table." (firstName, lastName, email, age, password, phone, picture, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $req->execute(
                    [
                     $obj->getFirstName(),
                     $obj->getLastName(),
                     $obj->getEmail(),
                     $obj->getAge(),
                     md5($obj->getPassword()),
                     $obj->getPhone(),
                     $obj->getPicture(),
                     $obj->getRole(),
                    ]
        );
        $req->closeCursor();
        return true;

    }//end createOne()


    /**
     * Get a user by their email.
     *
     * @param   string $email The email of the user.
     * @return array|null The user data if found, null otherwise.
     */
    public function getUserByEmail($email)
    {
        $this->getBdd();
        $req = self::$bdd->prepare('SELECT * FROM user WHERE email = ?');
        $req->execute([$email]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        return $user;

    }//end getUserByEmail()


    /**
     * Verify the password of a user.
     *
     * @param   string $email The email of the user.
     * @param   string $password The password to verify.
     * @return array|false The user data if the password is correct, false otherwise.
     */
    public function verifyPassword($email, $password)
    {
        $this->getBdd();
        $req = self::$bdd->prepare('SELECT * FROM user WHERE email = ? AND password = ?');
        $req->execute([$email, md5($password)]);
        $user = $req->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $this->openSession($user);
        }
        return $user;

    }//end verifyPassword()


    /**
     * Open a session for the given user.
     *
     * @param   array $user The user data.
     * @param   string $password The password to verify.
     * @return void
     */
    private function openSession($user)
    {
        $_SESSION['id'] = $user['id'];
        $_SESSION['firstName'] = $user['firstName'];
        $_SESSION['lastName'] = $user['lastName'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['age'] = $user['age'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['picture'] = $user['picture'];
        $_SESSION['role'] = $user['role'];

    }//end openSession()


    /**
     * Change the password of a user.
     *
     * @param   int $userId The ID of the user.
     * @param   string $newPassword The new password.
     * @return bool True if the password was changed successfully, false otherwise.
     */
    public function changePassword($userId, $newPassword)
    {
        $this->getBdd();
        $req = self::$bdd->prepare('UPDATE user SET password = ? WHERE id = ?');
        $hashedPassword = md5($newPassword);
        $user = $req->execute([$hashedPassword, $userId]);
        if ($user) {
            $this->openSession($user);
        }
        return $user;

    }//end changePassword()


    /**
     * Get a user by their ID.
     *
     * @param int $userId The ID of the user.
     * @return array|false The user data as an array if found, false otherwise.
     */
    public function getUserById($userId)
    {
        $this->getBdd();
        $req = self::$bdd->prepare('SELECT id, firstName, lastName, email, age, phone, picture, role FROM user WHERE id = ?');
        $req->execute([$userId]);
        $user = $req->fetch(PDO::FETCH_ASSOC);

        return $user;

    }//end getUserById()


    /**
     * Update a user with the specified options.
     *
     * @param array $user The user data as an array.
     * @param array $options The options to update.
     * @return bool True on success, false on failure.
     */
    public function updateUser($user, $options)
    {
        $this->getBdd();
        $set = [];
        $values = [];
        foreach ($options as $key => $value) {
            $set[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $user['id'];

        $req = self::$bdd->prepare("UPDATE user SET ".implode(", ", $set)." WHERE id = ?");

        $req->execute($values);
        return $req->rowCount() > 0;

    }//end updateUser()


    /**
     * Get all users from the database.
     *
     * @return array An array of user objects.
     */
    public function getAllUsers()
    {
        $this->getBdd();
        $req = self::$bdd->query("SELECT id, firstName, lastName, picture, role FROM user");
        $users = [];

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($data);
        }

        $req->closeCursor();
        return $users;

    }//end getAllUsers()


    /**
     * Update the role of a user in the database.
     *
     * @param int   $userId   The ID of the user.
     * @param array $options  The options for updating the user role.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateUserRole($userId, $options)
    {
        $this->getBdd();
        $set = [];
        $values = [];
        foreach ($options as $key => $value) {
            $set[] = "$key = ?";
            $values[] = $value;
        }

        $values[] = $userId;

        $req = self::$bdd->prepare("UPDATE user SET ".implode(", ", $set)." WHERE id = ?");
        $req->execute($values);

        return $req->rowCount() > 0;

    }//end updateUserRole()


    /**
     * Delete a user from the database.
     *
     * @param int $userId The ID of the user to delete.
     * @return bool True if the user was deleted successfully, false otherwise.
     */
    public function deleteUser($userId)
    {
        $this->getBdd();
        $req = self::$bdd->prepare("DELETE FROM user WHERE id = ?");
        $req->execute([$userId]);
        return $req->rowCount() > 0;

    }//end deleteUser()


}
