<?php

/**
 *
 */
class User
{

    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $age;
    private $password;
    private $phone;
    private $picture;
    private $role;

    /**
     * Class constructor.
     *
     * @param array $data The data used for object initialization.
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);

    }//end __construct()


    /**
     * Hydrates the object with the provided data.
     *
     * @param array $data The data to be used for object initialization.
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

    }//end hydrate()

    
    // setters

    /**
     * Set the ID of the user.
     *
     * @param integer $id The ID of the user.
     */
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }
        return $this->id;
    }

    public function setFirstName($firstName)
    {
        if (is_string($firstName)) {
            $this->firstName = $firstName;
        }
    }

    public function setLastName($lastName)
    {
        if (is_string($lastName)) {
            $this->lastName = $lastName;
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->email = $email;
        }
    }

    public function setAge($age)
    {
        $age = (int) $age;
        if ($age > 0) {
            $this->age = $age;
        }
    }

    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->password = $password;
        }
    }

    public function setPhone($phone)
    {
        $phone = (int) $phone;
        if ($phone > 0) {
            $this->phone = $phone;
        }
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }


    // getters

    /**
     * Get the ID of the user.
     *
     * @return integer The ID of the user.
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function getRole()
    {
        return $this->role;
    }
}
