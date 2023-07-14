<?php


/**
 *
 */
class User
{

    /**
     * The ID of the user.
     *
     * @var integer
     */

    private $id;

    /**
     * The firstname of the user.
     *
     * @var string
     */

    private $firstName;

    /**
     * The lastname of the user.
     *
     * @var string
     */

    private $lastName;

    /**
     * The email of the user.
     *
     * @var string
     */

    private $email;

    /**
     * The age of the user.
     *
     * @var integer
     */

    private $age;

    /**
     * The password of the user.
     *
     * @var string
     */

    private $password;

    /**
     * The phone number of the user.
     *
     * @var integer
     */

    private $phone;

    /**
     * The picture of the user.
     *
     * @var string
     */

    private $picture;

    /**
     * The role of the user.
     *
     * @var integer
     */

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
     *
     * @return void
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


    /**
     * Set the ID of the user.
     *
     * @param integer $id The ID of the user.
     *
     * @return void
     */
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }

        return $this->id;

    }//end setId()


    /**
     * Set the firstname of the user.
     *
     * @param string $firstName The firstname of the user.
     *
     * @return void
     */
    public function setFirstName($firstName)
    {
        if (is_string($firstName)) {
            $this->firstName = $firstName;
        }

    }//end setFirstName()


    /**
     * Set the lastname of the user.
     *
     * @param string $lastName The lastname of the user.
     *
     * @return void
     */
    public function setLastName($lastName)
    {
        if (is_string($lastName)) {
            $this->lastName = $lastName;
        }

    }//end setLastName()


    /**
     * Set the email of the user.
     *
     * @param string $email The email of the user.
     *
     * @return void
     */
    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->email = $email;
        }

    }//end setEmail()


    /**
     * Set the age of the user.
     *
     * @param integer $age The age of the user.
     *
     * @return void
     */
    public function setAge($age)
    {
        $age = (int) $age;
        if ($age > 0) {
            $this->age = $age;
        }

    }//end setAge()


    /**
     * Set the password of the user.
     *
     * @param string $password The password of the user.
     *
     * @return void
     */
    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->password = $password;
        }

    }//end setPassword()


    /**
     * Set the phone number of the user.
     *
     * @param integer $phone The phone number of the user.
     *
     * @return void
     */
    public function setPhone($phone)
    {
        $phone = (int) $phone;
        if ($phone > 0) {
            $this->phone = $phone;
        }

    }//end setPhone()


    /**
     * Set the picture of the user.
     *
     * @param string $picture The pictue of the user.
     *
     * @return void
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

    }//end setPicture()


    /**
     * Set the role of the user.
     *
     * @param integer $role The role of the user.
     *
     * @return void
     */
    public function setRole($role)
    {
        $this->role = $role;
        
    }//end setRole()


    /**
     * Get the ID of the user.
     *
     * @return integer The ID of the user.
     */
    public function getId()
    {
        return $this->id;

    }//end getId()


    /**
     * Get the firstname of the user.
     *
     * @return string The firstname of the user.
     */
    public function getFirstName()
    {
        return $this->firstName;

    }//end getFirstName()


    /**
     * Get the lastname of the user.
     *
     * @return string The lastname of the user.
     */
    public function getLastName()
    {
        return $this->lastName;

    }//end getLastName()


    /**
     * Get the email of the user.
     *
     * @return string The email of the user.
     */
    public function getEmail()
    {
        return $this->email;

    }//end getEmail()


    /**
     * Get the age of the user.
     *
     * @return integer The age of the user.
     */
    public function getAge()
    {
        return $this->age;

    }//end getAge()


    /**
     * Get the password of the user.
     *
     * @return string The password of the user.
     */
    public function getPassword()
    {
        return $this->password;

    }//end getPassword()


    /**
     * Get the phone number of the user.
     *
     * @return integer The phone number of the user.
     */
    public function getPhone()
    {
        return $this->phone;

    }//end getPhone()


    /**
     * Get the picture of the user.
     *
     * @return string The picture of the user.
     */
    public function getPicture()
    {
        return $this->picture;

    }//end getPicture()


    /**
     * Get the role of the user.
     *
     * @return integer The role of the user.
     */
    public function getRole()
    {
        return $this->role;

    }//end getRole()

    
}//end class
