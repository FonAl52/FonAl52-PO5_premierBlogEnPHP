<?php

/**
 *
 */
class Category
{


    /**
     * The ID of the category.
     *
     * @var integer
     */
    private $idCategory;

    
    /**
     * The name of the variable.
     *
     * @var string
     */
    private $name;


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
     * Set the ID of the category.
     *
     * @param integer $idCategory The ID of the category.
     */
    public function setIdCategory($idCategory)
    {
        $idCategory = (int) $idCategory;
        if ($idCategory > 0) {
            $this->idCategory = $idCategory;
        }

    }//end setIdCategory()


    /**
     * Set the name of the category.
     *
     * @param string $name The Name of the category.
     */
    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }

    }//end setName()


    // getters

    /**
     * Get the ID of the category.
     *
     * @return integer The ID of the category.
     */
    public function getIdCategory()
    {
        return $this->idCategory;

    }//end getIdCategory()


    /**
     * Get the Name of the category.
     *
     * @return string The Name of the category.
     */
    public function getName()
    {
        return $this->name;

    }//end getName()


}
