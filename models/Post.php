<?php


/**
 *
 */
class Post
{

    /**
     * The ID of the post.
     *
     * @var integer
     */

    private $id;

    /**
     * The category ID of the post.
     *
     * @var integer
     */

    private $categoryId;

    /**
     * The user ID of the post.
     *
     * @var integer
     */

    private $userId;


    /**
     * The title of the post.
     *
     * @var string
     */

    private $title;

    /**
     * The chapo of the post.
     *
     * @var string
     */

    private $chapo;

    /**
     * The picture of the post.
     *
     * @var string
     */

    private $picture;

    /**
     * The content of the post.
     *
     * @var string
     */

    private $content;

    /**
     * The date of creation of the post.
     *
     * @var integer
     */

    private $createdAt;

    /**
     * The update date of the post.
     *
     * @var integer
     */

    private $updatedAt;


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
     * Set the ID of the post.
     *
     * @param integer $id The ID of the post.
     *
     * @return void
     */
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }

    }//end setId()


    /**
     * Set the category ID of the post.
     *
     * @param integer $categoryId The category ID of the post.
     *
     * @return void
     */
    public function setCategoryId($categoryId)
    {
        $categoryId = (int) $categoryId;
        if ($categoryId > 0) {
            $this->categoryId = $categoryId;
        }

    }//end setCategoryId()


    /**
     * Set the user ID of the post.
     *
     * @param integer $userId The user ID of the post.
     *
     * @return void
     */
    public function setUserId($userId)
    {
        $userId = (int) $userId;
        if ($userId > 0) {
            $this->userId = $userId;
        }

    }//end setUserId()


    /**
     * Set the chapo of the post.
     *
     * @param string $chapo The chapo of the post.
     *
     * @return void
     */
    public function setChapo($chapo)
    {
        if (is_string($chapo)) {
            $this->chapo = $chapo;
        }

    }//end setChapo()


    /**
     * Set the picture of the post.
     *
     * @param string $picture The picture of the post.
     *
     * @return void
     */
    public function setPicture($picture)
    {
        if (is_string($picture)) {
            $this->picture = $picture;
        }
    
    }//end setPicture()


    /**
     * Set the Title of the post.
     *
     * @param string $title The Title of the post.
     *
     * @return void
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }

    }//end setTitle()


    /**
     * Set the content of the post.
     *
     * @param string $content The content of the post.
     *
     * @return void
     */
    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    
    }//end setContent()


    /**
     * Set the date of creation of the post.
     *
     * @param integer $createdAt The date of creation of the post.
     *
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

    }//end setCreatedAt()


    /**
     * Set the update date of the post.
     *
     * @param integer $updatedAt The update date of the post.
     *
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

    }//end setUpdatedAt()


    /**
     * Get the ID of the post.
     *
     * @return integer The ID of the post.
     */
    public function getId()
    {
        return $this->id;

    }//end getId()


    /**
     * Get the category ID of the post.
     *
     * @return integer The category ID of the post.
     */
    public function getCategoryId()
    {
        return $this->categoryId;

    }//end getCategoryId()


    /**
     * Get the user ID of the post.
     *
     * @return integer The user ID of the post.
     */
    public function getUserId()
    {
        return $this->userId;
    
    }//end getUserId()


    /**
     * Get the chapo of the post.
     *
     * @return string The chapo of the post.
     */
    public function getChapo()
    {
        return $this->chapo;

    }//end getChapo()


    /**
     * Get the picture of the post.
     *
     * @return string The picture of the post.
     */
    public function getPicture()
    {
        return $this->picture;

    }//end getPicture()


    /**
     * Get the title of the post.
     *
     * @return string The title of the post.
     */
    public function getTitle()
    {
        return $this->title;

    }//end getTitle()


    /**
     * Get the content of the post.
     *
     * @return string The content of the post.
     */
    public function getContent()
    {
        return $this->content;
    
    }//end getContent()


    /**
     * Get the date of creation of the post.
     *
     * @return integer The date of creation of the post.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;

    }//end getCreatedAt()


    /**
     * Get the update date of the post.
     *
     * @return integer The update date of the post.
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;

    }//end getUpdatedAt()


}//end class
