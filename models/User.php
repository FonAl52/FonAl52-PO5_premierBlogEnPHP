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


    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    //hdratation
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    //setters
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

    //getters
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
